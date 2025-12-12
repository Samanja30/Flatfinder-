/**
 * FlatFinders - Main JavaScript
 * Interactive functionality for the rental platform
 */

// ============================================
// DOM Ready
// ============================================
document.addEventListener('DOMContentLoaded', function() {
  initNavbar();
  initMobileNav();
  initSearchFilters();
  initPropertyFilters();
  initPriceSlider();
  initFavorites();
  initGallery();
  initForms();
  initAnimations();
  initCharts();
  initDashboard();
  initNotifications();
  initInteractiveButtons();
  loadFavorites();
  parseURLFilters();
  initCustomerDashboard();
  initOwnerDashboard();
  initAdminDashboard();
});

// ============================================
// Navbar Functionality
// ============================================
function initNavbar() {
  const navbar = document.querySelector('.navbar');
  if (!navbar) return;

  window.addEventListener('scroll', function() {
    if (window.scrollY > 50) {
      navbar.classList.add('scrolled');
    } else {
      navbar.classList.remove('scrolled');
    }
  });
}

function initMobileNav() {
  const toggle = document.querySelector('.navbar-toggle');
  const nav = document.querySelector('.navbar-nav');
  
  if (!toggle || !nav) return;

  toggle.addEventListener('click', function() {
    nav.classList.toggle('active');
    toggle.classList.toggle('active');
  });

  // Close nav when clicking outside
  document.addEventListener('click', function(e) {
    if (!nav.contains(e.target) && !toggle.contains(e.target)) {
      nav.classList.remove('active');
      toggle.classList.remove('active');
    }
  });
}

// ============================================
// Parse URL Filters
// ============================================
function parseURLFilters() {
  const urlParams = new URLSearchParams(window.location.search);
  
  // Apply location filter from URL
  const location = urlParams.get('location');
  if (location) {
    const locationFilter = document.getElementById('locationFilter');
    if (locationFilter) {
      locationFilter.value = location;
    }
  }
  
  // Apply type filter from URL
  const type = urlParams.get('type');
  if (type) {
    const typeFilter = document.getElementById('propertyTypeFilter');
    if (typeFilter) {
      typeFilter.value = type;
    }
    // Check bachelor only if type is bachelor
    if (type === 'bachelor') {
      const bachelorFilter = document.getElementById('bachelorFilter');
      if (bachelorFilter) bachelorFilter.checked = true;
    }
  }
  
  // Apply max price filter from URL
  const maxPrice = urlParams.get('maxPrice');
  if (maxPrice) {
    const maxPriceInput = document.getElementById('maxPriceInput');
    const maxPriceSlider = document.getElementById('maxPrice');
    if (maxPriceInput) maxPriceInput.value = maxPrice;
    if (maxPriceSlider) maxPriceSlider.value = maxPrice;
  }
  
  // Apply bedrooms filter from URL
  const bedrooms = urlParams.get('bedrooms');
  if (bedrooms) {
    const bedroomsFilter = document.getElementById('bedroomsFilter');
    if (bedroomsFilter) bedroomsFilter.value = bedrooms;
  }
  
  // Apply bachelor only filter from URL
  const bachelorOnly = urlParams.get('bachelorOnly');
  if (bachelorOnly === 'true') {
    const bachelorFilter = document.getElementById('bachelorFilter');
    if (bachelorFilter) bachelorFilter.checked = true;
  }
  
  // Trigger filter if on properties page
  if (window.location.pathname.includes('properties')) {
    setTimeout(filterProperties, 100);
  }
}

// ============================================
// Search Filters (Homepage)
// ============================================
function initSearchFilters() {
  const searchForm = document.querySelector('.search-form');
  if (!searchForm) return;

  searchForm.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(searchForm);
    const params = new URLSearchParams();
    
    for (let [key, value] of formData.entries()) {
      if (value) {
        params.append(key, value);
      }
    }

    // Redirect to properties page with filters
    window.location.href = 'properties.html?' + params.toString();
  });
}

// ============================================
// Price Range Slider
// ============================================
function initPriceSlider() {
  const minPrice = document.getElementById('minPrice');
  const maxPrice = document.getElementById('maxPrice');
  const minInput = document.getElementById('minPriceInput');
  const maxInput = document.getElementById('maxPriceInput');
  const rangeTrack = document.querySelector('.range-track');

  if (!minPrice || !maxPrice || !minInput || !maxInput) return;

  function updateSlider() {
    const minVal = parseInt(minPrice.value);
    const maxVal = parseInt(maxPrice.value);
    const min = parseInt(minPrice.min);
    const max = parseInt(minPrice.max);
    
    // Prevent overlap
    if (minVal >= maxVal - 1000) {
      if (this === minPrice) {
        minPrice.value = maxVal - 1000;
      } else {
        maxPrice.value = minVal + 1000;
      }
    }
    
    // Update input fields
    minInput.value = minPrice.value;
    maxInput.value = maxPrice.value;
    
    // Update track
    if (rangeTrack) {
      const leftPercent = ((minPrice.value - min) / (max - min)) * 100;
      const rightPercent = 100 - ((maxPrice.value - min) / (max - min)) * 100;
      rangeTrack.style.left = leftPercent + '%';
      rangeTrack.style.right = rightPercent + '%';
    }
    
    // Filter properties dynamically
    filterProperties();
  }

  minPrice.addEventListener('input', updateSlider);
  maxPrice.addEventListener('input', updateSlider);
  
  minInput.addEventListener('change', function() {
    minPrice.value = Math.max(parseInt(minPrice.min), parseInt(this.value) || parseInt(minPrice.min));
    updateSlider.call(minPrice);
  });
  
  maxInput.addEventListener('change', function() {
    maxPrice.value = Math.min(parseInt(maxPrice.max), parseInt(this.value) || parseInt(maxPrice.max));
    updateSlider.call(maxPrice);
  });

  // Initialize
  updateSlider.call(minPrice);
}

// ============================================
// Property Filters (Listings Page)
// ============================================
function initPropertyFilters() {
  const filtersForm = document.querySelector('.filters-sidebar');
  if (!filtersForm) return;

  // Filter dropdowns
  const filterElements = filtersForm.querySelectorAll('select');
  filterElements.forEach(el => {
    el.addEventListener('change', filterProperties);
  });

  // Amenity checkboxes
  const amenityCheckboxes = filtersForm.querySelectorAll('.amenities-list input[type="checkbox"]');
  amenityCheckboxes.forEach(cb => {
    cb.addEventListener('change', filterProperties);
  });

  // Bachelor filter checkbox
  const bachelorFilter = document.getElementById('bachelorFilter');
  if (bachelorFilter) {
    bachelorFilter.addEventListener('change', filterProperties);
  }

  // Clear filters button
  const clearBtn = document.querySelector('.clear-filters');
  if (clearBtn) {
    clearBtn.addEventListener('click', function() {
      // Reset all select elements
      filtersForm.querySelectorAll('select').forEach(select => {
        select.selectedIndex = 0;
      });
      
      // Reset all checkboxes
      filtersForm.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
        checkbox.checked = false;
      });
      
      // Reset price range
      const minPrice = document.getElementById('minPrice');
      const maxPrice = document.getElementById('maxPrice');
      const minInput = document.getElementById('minPriceInput');
      const maxInput = document.getElementById('maxPriceInput');
      
      if (minPrice) minPrice.value = minPrice.min;
      if (maxPrice) maxPrice.value = maxPrice.max;
      if (minInput) minInput.value = minPrice ? minPrice.min : '';
      if (maxInput) maxInput.value = maxPrice ? maxPrice.max : '';
      
      // Update track
      const rangeTrack = document.querySelector('.range-track');
      if (rangeTrack) {
        rangeTrack.style.left = '0%';
        rangeTrack.style.right = '0%';
      }
      
      // Refilter
      filterProperties();
      
      // Show notification
      showNotification('Filters cleared!', 'info');
    });
  }

  // Sort functionality
  const sortSelect = document.querySelector('.results-sort select');
  if (sortSelect) {
    sortSelect.addEventListener('change', function() {
      sortProperties(this.value);
    });
  }
}

// ============================================
// Filter Properties Function
// ============================================
function filterProperties() {
  const cards = document.querySelectorAll('.property-card, .property-list-card');
  if (!cards.length) return;

  // Get filter values
  const location = document.getElementById('locationFilter')?.value?.toLowerCase() || '';
  const propertyType = document.getElementById('propertyTypeFilter')?.value?.toLowerCase() || '';
  const bedrooms = document.getElementById('bedroomsFilter')?.value || '';
  const minPrice = parseInt(document.getElementById('minPrice')?.value) || 0;
  const maxPrice = parseInt(document.getElementById('maxPrice')?.value) || Infinity;
  const bachelorOnly = document.getElementById('bachelorFilter')?.checked || false;
  
  // Get selected amenities
  const amenities = [];
  document.querySelectorAll('.amenities-list input[type="checkbox"]:checked').forEach(cb => {
    amenities.push(cb.value.toLowerCase());
  });

  let visibleCount = 0;
  let totalCount = cards.length;

  cards.forEach(card => {
    const cardLocation = (card.dataset.location || '').toLowerCase();
    const cardType = (card.dataset.type || '').toLowerCase();
    const cardBedrooms = card.dataset.bedrooms || '';
    const cardPrice = parseInt(card.dataset.price) || 0;
    const cardBachelor = card.dataset.bachelor === 'true';
    const cardAmenities = (card.dataset.amenities || '').toLowerCase().split(',');

    let show = true;

    // Location filter
    if (location && cardLocation !== location) {
      show = false;
    }
    
    // Property type filter
    if (propertyType && cardType !== propertyType) {
      show = false;
    }
    
    // Bedrooms filter
    if (bedrooms && cardBedrooms !== bedrooms) {
      show = false;
    }
    
    // Price range filter
    if (cardPrice < minPrice || cardPrice > maxPrice) {
      show = false;
    }
    
    // Bachelor only filter - when checked, show ONLY bachelor flats
    if (bachelorOnly && !cardBachelor) {
      show = false;
    }
    
    // Amenities filter
    if (amenities.length > 0) {
      const hasAllAmenities = amenities.every(a => cardAmenities.includes(a));
      if (!hasAllAmenities) show = false;
    }

    // Show/hide card with animation
    if (show) {
      card.style.display = '';
      card.style.animation = 'fadeIn 0.3s ease forwards';
      visibleCount++;
    } else {
      card.style.display = 'none';
    }
  });

  // Update results count
  const countEl = document.querySelector('.results-count strong');
  if (countEl) {
    countEl.textContent = visibleCount;
  }
  
  // Update total count
  const totalEl = document.querySelector('.results-count');
  if (totalEl) {
    totalEl.innerHTML = `Showing <strong>${visibleCount}</strong> of ${totalCount} properties`;
  }

  // Show no results message if needed
  const noResultsMsg = document.querySelector('.no-results-message');
  const gridContainer = document.querySelector('.property-grid');
  
  if (visibleCount === 0 && gridContainer) {
    if (!noResultsMsg) {
      const msg = document.createElement('div');
      msg.className = 'no-results-message';
      msg.style.cssText = 'grid-column: 1/-1; text-align: center; padding: 3rem; color: var(--gray-600);';
      msg.innerHTML = `
        <svg viewBox="0 0 24 24" style="width: 48px; height: 48px; fill: var(--gray-400); margin: 0 auto 1rem;">
          <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
        <h4 style="margin-bottom: 0.5rem;">No properties found</h4>
        <p>Try adjusting your filters to find more results</p>
      `;
      gridContainer.appendChild(msg);
    }
  } else if (noResultsMsg) {
    noResultsMsg.remove();
  }
}

// ============================================
// Sort Properties
// ============================================
function sortProperties(sortBy) {
  const container = document.querySelector('.property-grid');
  if (!container) return;

  const cards = Array.from(container.querySelectorAll('.property-card, .property-list-card'));
  
  cards.sort((a, b) => {
    const priceA = parseInt(a.dataset.price) || 0;
    const priceB = parseInt(b.dataset.price) || 0;
    const dateA = new Date(a.dataset.date || 0);
    const dateB = new Date(b.dataset.date || 0);

    switch (sortBy) {
      case 'price-low':
        return priceA - priceB;
      case 'price-high':
        return priceB - priceA;
      case 'newest':
        return dateB - dateA;
      default:
        return 0;
    }
  });

  // Re-append cards in sorted order
  cards.forEach((card, index) => {
    card.style.animation = 'none';
    card.style.opacity = '0';
    container.appendChild(card);
    
    // Animate with delay
    setTimeout(() => {
      card.style.animation = `fadeIn 0.3s ease forwards`;
      card.style.animationDelay = `${index * 0.05}s`;
    }, 10);
  });
}

// ============================================
// View Toggle (Grid/List)
// ============================================
function toggleView(view) {
  const gridContainer = document.querySelector('.property-grid');
  const gridBtn = document.querySelector('.view-toggle .grid-view');
  const listBtn = document.querySelector('.view-toggle .list-view');

  if (!gridContainer) return;

  if (view === 'grid') {
    gridContainer.style.gridTemplateColumns = 'repeat(auto-fill, minmax(320px, 1fr))';
    gridBtn?.classList.add('active');
    listBtn?.classList.remove('active');
  } else if (view === 'list') {
    gridContainer.style.gridTemplateColumns = '1fr';
    listBtn?.classList.add('active');
    gridBtn?.classList.remove('active');
  }
}

// ============================================
// Favorites
// ============================================
function initFavorites() {
  document.querySelectorAll('.property-favorite').forEach(btn => {
    btn.addEventListener('click', function(e) {
      e.preventDefault();
      e.stopPropagation();
      
      this.classList.toggle('active');
      
      const card = this.closest('.property-card, .property-list-card, .saved-property-card');
      const propertyId = card?.dataset.id;
      
      if (propertyId) {
        toggleFavorite(propertyId);
        
        if (this.classList.contains('active')) {
          showNotification('Property saved to favorites!', 'success');
        } else {
          showNotification('Property removed from favorites', 'info');
        }
      }
    });
  });
}

function toggleFavorite(propertyId) {
  let favorites = JSON.parse(localStorage.getItem('flatfinders_favorites') || '[]');
  let favoritesData = JSON.parse(localStorage.getItem('flatfinders_favorites_data') || '{}');
  
  const card = document.querySelector(`[data-id="${propertyId}"]`);
  
  if (favorites.includes(propertyId)) {
    // Remove from favorites
    favorites = favorites.filter(id => id !== propertyId);
    delete favoritesData[propertyId];
  } else {
    // Add to favorites
    favorites.push(propertyId);
    
    // Store property data
    if (card) {
      favoritesData[propertyId] = {
        id: propertyId,
        title: card.querySelector('.property-title, h3')?.textContent || 'Property',
        price: card.dataset.price || '0',
        location: card.dataset.location || '',
        locationText: card.querySelector('.property-location')?.textContent?.trim() || '',
        type: card.dataset.type || '',
        bedrooms: card.dataset.bedrooms || '',
        bathrooms: card.dataset.bathrooms || '1',
        sqft: card.dataset.sqft || '',
        image: card.querySelector('img')?.src || '',
        bachelor: card.dataset.bachelor || 'false'
      };
    }
  }
  
  localStorage.setItem('flatfinders_favorites', JSON.stringify(favorites));
  localStorage.setItem('flatfinders_favorites_data', JSON.stringify(favoritesData));
  updateFavoritesCount();
  
  // Reload saved properties if on dashboard
  if (window.location.pathname.includes('customer-dashboard')) {
    loadSavedProperties();
  }
}

function loadFavorites() {
  const favorites = JSON.parse(localStorage.getItem('flatfinders_favorites') || '[]');
  
  favorites.forEach(id => {
    const btn = document.querySelector(`[data-id="${id}"] .property-favorite`);
    if (btn) {
      btn.classList.add('active');
    }
  });
  
  updateFavoritesCount();
}

function updateFavoritesCount() {
  const favorites = JSON.parse(localStorage.getItem('flatfinders_favorites') || '[]');
  const countEl = document.querySelector('.favorites-count');
  if (countEl) {
    countEl.textContent = favorites.length;
  }
}

// ============================================
// Notifications
// ============================================
function showNotification(message, type = 'info') {
  // Remove existing notification
  const existing = document.querySelector('.notification-toast');
  if (existing) existing.remove();
  
  const notification = document.createElement('div');
  notification.className = `notification-toast notification-${type}`;
  notification.style.cssText = `
    position: fixed;
    bottom: 20px;
    right: 20px;
    padding: 1rem 1.5rem;
    background: ${type === 'success' ? '#28a745' : type === 'error' ? '#dc3545' : '#17a2b8'};
    color: white;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    z-index: 9999;
    animation: slideInRight 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  `;
  
  const icon = type === 'success' ? '✓' : type === 'error' ? '✕' : 'ℹ';
  notification.innerHTML = `<span>${icon}</span> ${message}`;
  
  document.body.appendChild(notification);
  
  // Auto remove after 3 seconds
  setTimeout(() => {
    notification.style.animation = 'slideOutRight 0.3s ease forwards';
    setTimeout(() => notification.remove(), 300);
  }, 3000);
}

// Add animation keyframes
const style = document.createElement('style');
style.textContent = `
  @keyframes slideInRight {
    from { transform: translateX(100%); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
  }
  @keyframes slideOutRight {
    from { transform: translateX(0); opacity: 1; }
    to { transform: translateX(100%); opacity: 0; }
  }
  @keyframes fadeOut {
    from { opacity: 1; }
    to { opacity: 0; transform: translateX(20px); }
  }
`;
document.head.appendChild(style);

// ============================================
// Image Gallery (Property Detail)
// ============================================
function initGallery() {
  const gallery = document.querySelector('.property-gallery');
  if (!gallery) return;
  
  // Track recently viewed property
  trackRecentlyViewed();

  const mainImage = gallery.querySelector('.gallery-main img');
  const thumbnails = gallery.querySelectorAll('.gallery-thumbnails img');
  const prevBtn = gallery.querySelector('.gallery-nav.prev');
  const nextBtn = gallery.querySelector('.gallery-nav.next');
  
  if (!mainImage || !thumbnails.length) return;

  let currentIndex = 0;
  const images = [
    'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?w=1200&q=80',
    'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?w=1200&q=80',
    'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=1200&q=80',
    'https://images.unsplash.com/photo-1493809842364-78817add7ffb?w=1200&q=80',
    'https://images.unsplash.com/photo-1560185007-c5ca9d2c014d?w=1200&q=80'
  ];

  function showImage(index) {
    if (index < 0) index = images.length - 1;
    if (index >= images.length) index = 0;
    
    currentIndex = index;
    
    // Fade transition
    mainImage.style.opacity = '0';
    setTimeout(() => {
      mainImage.src = images[index];
      mainImage.style.opacity = '1';
    }, 200);
    
    thumbnails.forEach((thumb, i) => {
      thumb.classList.toggle('active', i === index);
    });
  }

  thumbnails.forEach((thumb, index) => {
    thumb.addEventListener('click', () => showImage(index));
  });

  if (prevBtn) {
    prevBtn.addEventListener('click', () => showImage(currentIndex - 1));
  }

  if (nextBtn) {
    nextBtn.addEventListener('click', () => showImage(currentIndex + 1));
  }

  // Keyboard navigation
  document.addEventListener('keydown', function(e) {
    if (!gallery.closest('.property-detail')) return;
    if (e.key === 'ArrowLeft') showImage(currentIndex - 1);
    if (e.key === 'ArrowRight') showImage(currentIndex + 1);
  });

  // Initialize
  showImage(0);
}

// ============================================
// Form Validation & Authentication
// ============================================
function initForms() {
  // Login Form
  const loginForm = document.getElementById('loginForm');
  if (loginForm) {
    loginForm.addEventListener('submit', handleLogin);
  }

  // Register Form
  const registerForm = document.getElementById('registerForm');
  if (registerForm) {
    registerForm.addEventListener('submit', handleRegister);
  }

  // Contact/Inquiry Form
  const inquiryForm = document.getElementById('inquiryForm');
  if (inquiryForm) {
    inquiryForm.addEventListener('submit', handleInquiry);
  }

  // Post Property Form
  const propertyForm = document.getElementById('propertyForm');
  if (propertyForm) {
    propertyForm.addEventListener('submit', handlePropertySubmit);
  }

  // Password toggle
  document.querySelectorAll('.password-toggle .toggle-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      const input = this.parentElement.querySelector('input');
      const type = input.type === 'password' ? 'text' : 'password';
      input.type = type;
    });
  });

  // Role selection
  document.querySelectorAll('.role-option').forEach(option => {
    option.addEventListener('click', function() {
      document.querySelectorAll('.role-option').forEach(opt => opt.classList.remove('selected'));
      this.classList.add('selected');
      const input = document.getElementById('userRole');
      if (input) {
        input.value = this.dataset.role;
      }
    });
  });
}

function handleLogin(e) {
  e.preventDefault();
  
  console.log('========================================');
  console.log('🔐 LOGIN ATTEMPT STARTED');
  console.log('========================================');
  
  const roleSelect = document.getElementById('userRole');
  const email = document.getElementById('email').value;
  const password = document.getElementById('password').value;
  const submitBtn = e.target.querySelector('button[type="submit"]');
  
  // Get selected role
  const selectedRole = roleSelect ? roleSelect.value : '';
  
  console.log('👤 Selected Role:', selectedRole);
  console.log('📧 Email:', email);
  console.log('🔑 Password length:', password.length, 'chars');
  
  // Validate
  let isValid = true;
  clearErrors();
  
  // Validate role selection
  if (!selectedRole || selectedRole === '') {
    console.log('❌ No role selected');
    showError('userRole', 'Please select your role');
    isValid = false;
  }
  
  if (!validateEmail(email)) {
    console.log('❌ Email validation failed');
    showError('email', 'Please enter a valid email address');
    isValid = false;
  }
  
  if (password.length < 6) {
    console.log('❌ Password too short');
    showError('password', 'Password must be at least 6 characters');
    isValid = false;
  }
  
  if (!isValid) {
    console.log('❌ Frontend validation failed - stopping');
    return;
  }
  
  console.log('✅ Frontend validation passed');
  console.log('🌐 Calling backend API...');
  
  // Disable button and show loading
  if (submitBtn) {
    submitBtn.disabled = true;
    submitBtn.textContent = 'Signing in...';
  }
  
  // Call backend API
  const apiUrl = '/Flatfinder/backend/api/auth/login.php';
  console.log('🔗 API URL:', apiUrl);
  
  fetch(apiUrl, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      email: email,
      password: password
    })
  })
  .then(response => {
    console.log('📡 Response status:', response.status);
    console.log('📡 Response ok:', response.ok);
    return response.json();
  })
  .then(data => {
    console.log('📦 Backend response:', data);
    
    if (data.success === true) {
      console.log('✅ Backend password validation SUCCESS');
      console.log('👤 User data from backend:', data.data.user);
      
      const backendRole = data.data.user.role;
      console.log('🔍 Backend role:', backendRole);
      console.log('🔍 Selected role:', selectedRole);
      
      // CRITICAL: Check if selected role matches backend role
      if (backendRole !== selectedRole) {
        console.log('❌ ROLE MISMATCH!');
        console.log('   Selected:', selectedRole);
        console.log('   Actual:', backendRole);
        
        showNotification('Wrong credentials', 'error');
        
        // Re-enable button
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.textContent = 'Sign In';
        }
        
        console.log('========================================');
        return;
      }
      
      console.log('✅ Role verification SUCCESS');
      
      // Store user session from backend response
      const user = {
        id: data.data.user.id,
        email: data.data.user.email,
        name: data.data.user.name,
        role: data.data.user.role,
        phone: data.data.user.phone,
        profile_image: data.data.user.profile_image,
        loginTime: new Date().toISOString()
      };
      
      console.log('💾 Storing user session:', user);
      sessionStorage.setItem('flatfinders_user', JSON.stringify(user));
      localStorage.setItem('flatfinders_user', JSON.stringify(user));
      
      showNotification('Login successful! Redirecting...', 'success');
      
      console.log('🚀 Redirecting to dashboard in 1 second...');
      // Redirect based on role
      setTimeout(() => {
        redirectToDashboard(user.role);
      }, 1000);
    } else {
      console.log('❌ Backend authentication FAILED');
      console.log('❌ Error message:', data.message);
      
      // Show "Wrong credentials" for any authentication failure
      showNotification('Wrong credentials', 'error');
      
      // Re-enable button
      if (submitBtn) {
        submitBtn.disabled = false;
        submitBtn.textContent = 'Sign In';
      }
    }
    
    console.log('========================================');
  })
  .catch(error => {
    console.error('❌ FETCH ERROR:', error);
    console.error('❌ Error details:', error.message);
    console.error('⚠️  This usually means:');
    console.error('   1. XAMPP Apache is not running');
    console.error('   2. Backend file path is wrong');
    console.error('   3. CORS issue');
    showNotification('Connection error. Please make sure XAMPP Apache and MySQL are running.', 'error');
    
    // Re-enable button
    if (submitBtn) {
      submitBtn.disabled = false;
      submitBtn.textContent = 'Sign In';
    }
    
    console.log('========================================');
  });
}

function handleRegister(e) {
  e.preventDefault();
  
  const name = document.getElementById('name').value;
  const email = document.getElementById('email').value;
  const phone = document.getElementById('phone')?.value || '';
  const password = document.getElementById('password').value;
  const confirmPassword = document.getElementById('confirmPassword').value;
  const role = document.getElementById('userRole')?.value || 'customer';
  const terms = document.querySelector('input[name="terms"]')?.checked;
  
  let isValid = true;
  clearErrors();
  
  if (name.length < 2) {
    showError('name', 'Name must be at least 2 characters');
    isValid = false;
  }
  
  if (!validateEmail(email)) {
    showError('email', 'Please enter a valid email address');
    isValid = false;
  }
  
  if (password.length < 6) {
    showError('password', 'Password must be at least 6 characters');
    isValid = false;
  }
  
  if (password !== confirmPassword) {
    showError('confirmPassword', 'Passwords do not match');
    isValid = false;
  }
  
  if (!terms) {
    showNotification('Please accept the Terms of Service', 'error');
    isValid = false;
  }
  
  if (isValid) {
    // Create user
    const user = { 
      name, 
      email, 
      phone,
      role,
      registrationDate: new Date().toISOString()
    };
    
    sessionStorage.setItem('flatfinders_user', JSON.stringify(user));
    localStorage.setItem('flatfinders_user', JSON.stringify(user));
    
    showNotification('Registration successful! Welcome to FlatFinders.', 'success');
    
    // Redirect to dashboard
    setTimeout(() => {
      redirectToDashboard(role);
    }, 1500);
  }
}

function handleInquiry(e) {
  e.preventDefault();
  
  const name = document.getElementById('inquiryName')?.value || '';
  const email = document.getElementById('inquiryEmail')?.value || '';
  const phone = document.getElementById('inquiryPhone')?.value || '';
  const message = document.getElementById('inquiryMessage')?.value || '';
  
  let isValid = true;
  
  if (name.length < 2) {
    showError('inquiryName', 'Please enter your name');
    isValid = false;
  }
  
  if (!validateEmail(email)) {
    showError('inquiryEmail', 'Please enter a valid email address');
    isValid = false;
  }
  
  if (message.length < 10) {
    showError('inquiryMessage', 'Message must be at least 10 characters');
    isValid = false;
  }
  
  if (isValid) {
    // Get property info from page
    const propertyTitle = document.querySelector('.property-title')?.textContent || 'Unknown Property';
    const propertyPrice = document.querySelector('.property-price')?.textContent || '';
    const propertyLocation = document.querySelector('.property-location')?.textContent || '';
    
    // Store inquiry
    const inquiries = JSON.parse(localStorage.getItem('flatfinders_inquiries') || '[]');
    inquiries.push({
      id: Date.now().toString(),
      name,
      email,
      phone,
      message,
      propertyId: document.querySelector('[data-id]')?.dataset.id,
      propertyTitle,
      propertyPrice,
      propertyLocation,
      date: new Date().toISOString(),
      status: 'new'
    });
    localStorage.setItem('flatfinders_inquiries', JSON.stringify(inquiries));
    
    showNotification('Your inquiry has been sent! The property owner will contact you soon.', 'success');
    e.target.reset();
  }
}

function handlePropertySubmit(e) {
  e.preventDefault();
  
  const formData = new FormData(e.target);
  const data = Object.fromEntries(formData.entries());
  
  // Get current user
  const user = checkAuth();
  
  // Store property
  const properties = JSON.parse(localStorage.getItem('flatfinders_properties') || '[]');
  data.id = Date.now().toString();
  data.status = 'pending';
  data.dateSubmitted = new Date().toISOString();
  data.owner = user ? user.name : 'Unknown';
  data.ownerEmail = user ? user.email : '';
  data.views = 0;
  properties.push(data);
  localStorage.setItem('flatfinders_properties', JSON.stringify(properties));
  
  showNotification('Property submitted for review! Our admin team will review your listing.', 'success');
  
  // Redirect to owner dashboard
  setTimeout(() => {
    window.location.href = 'owner-dashboard.html';
  }, 2000);
}

function validateEmail(email) {
  const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return re.test(email);
}

function showError(fieldId, message) {
  const field = document.getElementById(fieldId);
  if (!field) return;
  
  field.classList.add('error');
  field.style.borderColor = '#dc3545';
  
  let errorEl = field.parentElement.querySelector('.form-error');
  if (!errorEl) {
    errorEl = document.createElement('div');
    errorEl.className = 'form-error';
    errorEl.style.cssText = 'font-size: 0.85rem; color: #dc3545; margin-top: 0.35rem;';
    field.parentElement.appendChild(errorEl);
  }
  errorEl.textContent = message;
  
  // Remove error on focus
  field.addEventListener('focus', function() {
    this.classList.remove('error');
    this.style.borderColor = '';
    const error = this.parentElement.querySelector('.form-error');
    if (error) error.remove();
  }, { once: true });
}

function clearErrors() {
  document.querySelectorAll('.form-error').forEach(el => el.remove());
  document.querySelectorAll('.error').forEach(el => {
    el.classList.remove('error');
    el.style.borderColor = '';
  });
}

function determineUserRole(email) {
  const emailLower = email.toLowerCase();
  if (emailLower.includes('admin')) return 'admin';
  if (emailLower.includes('owner') || emailLower.includes('landlord') || emailLower.includes('property')) return 'owner';
  return 'customer';
}

function redirectToDashboard(role) {
  switch (role) {
    case 'admin':
      window.location.href = 'admin-dashboard.html';
      break;
    case 'owner':
      window.location.href = 'owner-dashboard.html';
      break;
    default:
      window.location.href = 'customer-dashboard.html';
  }
}

// Check if user is logged in
function checkAuth() {
  const user = JSON.parse(sessionStorage.getItem('flatfinders_user') || localStorage.getItem('flatfinders_user') || 'null');
  return user;
}

// Logout function
function logout() {
  sessionStorage.removeItem('flatfinders_user');
  localStorage.removeItem('flatfinders_user');
  showNotification('You have been logged out', 'info');
  setTimeout(() => {
    window.location.href = 'index.html';
  }, 1000);
}

// ============================================
// Animations
// ============================================
function initAnimations() {
  // Intersection Observer for scroll animations
  const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
  };

  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry, index) => {
      if (entry.isIntersecting) {
        entry.target.style.animationDelay = `${index * 0.1}s`;
        entry.target.classList.add('animate-fadeIn');
        observer.unobserve(entry.target);
      }
    });
  }, observerOptions);

  document.querySelectorAll('.property-card, .type-card, .step-card, .testimonial-card, .stat-card').forEach(el => {
    el.style.opacity = '0';
    observer.observe(el);
  });
}

// ============================================
// Dashboard Charts
// ============================================
let chartData = {
  2021: [8, 12, 10, 15, 13, 18, 16, 20, 19, 22, 21, 25],
  2022: [10, 15, 12, 20, 18, 25, 22, 28, 26, 32, 30, 35],
  2023: [11, 16, 13, 22, 20, 27, 25, 32, 30, 37, 35, 42],
  2024: [12, 19, 15, 25, 22, 30, 28, 35, 32, 40, 38, 45],
  2025: [15, 22, 18, 28, 25, 35, 32, 40, 38, 45, 42, 50]
};

function initCharts() {
  // Properties Chart
  const propertiesChart = document.getElementById('propertiesChart');
  if (propertiesChart) {
    renderPropertiesChart(propertiesChart, 2024);
    
    // Year selector
    const yearSelect = propertiesChart.closest('.dashboard-card')?.querySelector('select');
    if (yearSelect) {
      yearSelect.addEventListener('change', function() {
        renderPropertiesChart(propertiesChart, parseInt(this.value));
      });
    }
  }

  // Inquiries Chart
  const inquiriesChart = document.getElementById('inquiriesChart');
  if (inquiriesChart) {
    renderInquiriesChart(inquiriesChart);
  }

  // Property Types Chart
  const typesChart = document.getElementById('typesChart');
  if (typesChart) {
    renderTypesChart(typesChart);
  }
  
  // Year selection for Property Types Chart
  const typesYearSelect = document.getElementById('typesYearSelect');
  if (typesYearSelect && typesChart) {
    typesYearSelect.addEventListener('change', function() {
      renderTypesChart(typesChart, parseInt(this.value));
    });
  }
  
  // Year selection for Properties Chart
  const propertiesYearSelect = document.getElementById('propertiesYearSelect');
  if (propertiesYearSelect && propertiesChart) {
    propertiesYearSelect.addEventListener('change', function() {
      renderPropertiesChart(propertiesChart, parseInt(this.value));
    });
  }
  
  // Year selection for Inquiries Chart
  const inquiriesYearSelect = document.getElementById('inquiriesYearSelect');
  if (inquiriesYearSelect && inquiriesChart) {
    inquiriesYearSelect.addEventListener('change', function() {
      renderInquiriesChart(inquiriesChart, parseInt(this.value));
    });
  }
}

function renderPropertiesChart(canvas, year = 2024) {
  const ctx = canvas.getContext('2d');
  const data = chartData[year] || chartData[2024];
  const labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
  
  drawBarChart(ctx, canvas, data, labels, '#c9a66b');
}

function renderInquiriesChart(canvas, year = 2024) {
  const ctx = canvas.getContext('2d');
  // Data varies by year
  const yearData = {
    2021: [25, 32, 40, 38, 45, 52, 58, 62, 58, 68, 75, 80],
    2022: [35, 42, 55, 50, 60, 68, 75, 80, 75, 88, 95, 100],
    2023: [45, 55, 70, 68, 75, 85, 95, 100, 92, 110, 120, 125],
    2024: [65, 78, 90, 81, 95, 110, 125, 130, 115, 140, 155, 160],
    2025: [75, 88, 100, 95, 110, 125, 140, 150, 135, 160, 175, 185]
  };
  const data = yearData[year] || yearData[2024];
  const labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
  
  drawLineChart(ctx, canvas, data, labels, '#17a2b8');
}

function renderTypesChart(canvas, year = 2024) {
  const ctx = canvas.getContext('2d');
  
  // Property type distribution varies by year
  // Trend: Bachelor flats gaining popularity, Houses declining
  const yearData = {
    2021: {
      data: [38, 32, 20, 10],
      labels: ['Bachelor (38%)', 'Apartment (32%)', 'House (20%)', 'Others (10%)']
    },
    2022: {
      data: [40, 31, 18, 11],
      labels: ['Bachelor (40%)', 'Apartment (31%)', 'House (18%)', 'Others (11%)']
    },
    2023: {
      data: [43, 30, 16, 11],
      labels: ['Bachelor (43%)', 'Apartment (30%)', 'House (16%)', 'Others (11%)']
    },
    2024: {
      data: [45, 30, 15, 10],
      labels: ['Bachelor (45%)', 'Apartment (30%)', 'House (15%)', 'Others (10%)']
    },
    2025: {
      data: [48, 29, 13, 10],
      labels: ['Bachelor (48%)', 'Apartment (29%)', 'House (13%)', 'Others (10%)']
    }
  };
  
  const selectedData = yearData[year] || yearData[2024];
  const data = selectedData.data;
  const labels = selectedData.labels;
  const colors = ['#c9a66b', '#1a1a2e', '#17a2b8', '#28a745'];
  
  drawPieChart(ctx, canvas, data, labels, colors);
}

function drawBarChart(ctx, canvas, data, labels, color) {
  const width = canvas.width = canvas.parentElement.offsetWidth;
  const height = canvas.height = 280;
  const padding = 50;
  const barWidth = (width - padding * 2) / data.length - 12;
  const maxValue = Math.max(...data) * 1.1;
  
  ctx.clearRect(0, 0, width, height);
  
  // Draw grid lines
  ctx.strokeStyle = '#e9ecef';
  ctx.lineWidth = 1;
  for (let i = 0; i <= 5; i++) {
    const y = padding + (i * (height - padding * 2) / 5);
    ctx.beginPath();
    ctx.moveTo(padding, y);
    ctx.lineTo(width - padding, y);
    ctx.stroke();
  }
  
  // Draw bars with animation
  data.forEach((value, index) => {
    const barHeight = (value / maxValue) * (height - padding * 2);
    const x = padding + index * (barWidth + 12);
    const y = height - padding - barHeight;
    
    // Bar gradient
    const gradient = ctx.createLinearGradient(x, y, x, height - padding);
    gradient.addColorStop(0, color);
    gradient.addColorStop(1, '#d4b87d');
    
    ctx.fillStyle = gradient;
    ctx.beginPath();
    ctx.roundRect(x, y, barWidth, barHeight, [4, 4, 0, 0]);
    ctx.fill();
    
    // Value on top
    ctx.fillStyle = '#495057';
    ctx.font = '11px Outfit';
    ctx.textAlign = 'center';
    ctx.fillText(value, x + barWidth / 2, y - 8);
    
    // Label
    ctx.fillStyle = '#6c757d';
    ctx.fillText(labels[index], x + barWidth / 2, height - 20);
  });
}

function drawLineChart(ctx, canvas, data, labels, color) {
  const width = canvas.width = canvas.parentElement.offsetWidth;
  const height = canvas.height = 280;
  const padding = 50;
  const maxValue = Math.max(...data) * 1.1;
  const stepX = (width - padding * 2) / (data.length - 1);
  
  ctx.clearRect(0, 0, width, height);
  
  // Draw grid lines
  ctx.strokeStyle = '#e9ecef';
  ctx.lineWidth = 1;
  for (let i = 0; i <= 5; i++) {
    const y = padding + (i * (height - padding * 2) / 5);
    ctx.beginPath();
    ctx.moveTo(padding, y);
    ctx.lineTo(width - padding, y);
    ctx.stroke();
  }
  
  // Draw area fill
  ctx.beginPath();
  ctx.moveTo(padding, height - padding);
  data.forEach((value, index) => {
    const x = padding + index * stepX;
    const y = height - padding - (value / maxValue) * (height - padding * 2);
    ctx.lineTo(x, y);
  });
  ctx.lineTo(padding + (data.length - 1) * stepX, height - padding);
  ctx.closePath();
  
  const gradient = ctx.createLinearGradient(0, 0, 0, height);
  gradient.addColorStop(0, color + '40');
  gradient.addColorStop(1, color + '05');
  ctx.fillStyle = gradient;
  ctx.fill();
  
  // Draw line
  ctx.beginPath();
  ctx.strokeStyle = color;
  ctx.lineWidth = 3;
  ctx.lineJoin = 'round';
  ctx.lineCap = 'round';
  
  data.forEach((value, index) => {
    const x = padding + index * stepX;
    const y = height - padding - (value / maxValue) * (height - padding * 2);
    
    if (index === 0) {
      ctx.moveTo(x, y);
    } else {
      ctx.lineTo(x, y);
    }
  });
  
  ctx.stroke();
  
  // Draw points and labels
  data.forEach((value, index) => {
    const x = padding + index * stepX;
    const y = height - padding - (value / maxValue) * (height - padding * 2);
    
    ctx.beginPath();
    ctx.fillStyle = '#fff';
    ctx.arc(x, y, 6, 0, Math.PI * 2);
    ctx.fill();
    ctx.strokeStyle = color;
    ctx.lineWidth = 3;
    ctx.stroke();
    
    // Label
    ctx.fillStyle = '#6c757d';
    ctx.font = '11px Outfit';
    ctx.textAlign = 'center';
    ctx.fillText(labels[index], x, height - 20);
  });
}

function drawPieChart(ctx, canvas, data, labels, colors) {
  const width = canvas.width = Math.min(canvas.parentElement.offsetWidth, 300);
  const height = canvas.height = 300;
  const centerX = width / 2;
  const centerY = height / 2 - 30;
  const radius = Math.min(width, height) / 2 - 60;
  const total = data.reduce((sum, val) => sum + val, 0);
  
  ctx.clearRect(0, 0, width, height);
  
  let startAngle = -Math.PI / 2;
  
  data.forEach((value, index) => {
    const sliceAngle = (value / total) * Math.PI * 2;
    
    ctx.beginPath();
    ctx.moveTo(centerX, centerY);
    ctx.arc(centerX, centerY, radius, startAngle, startAngle + sliceAngle);
    ctx.closePath();
    ctx.fillStyle = colors[index];
    ctx.fill();
    
    // Draw white border
    ctx.strokeStyle = '#fff';
    ctx.lineWidth = 2;
    ctx.stroke();
    
    startAngle += sliceAngle;
  });
  
  // Draw center circle (donut effect)
  ctx.beginPath();
  ctx.arc(centerX, centerY, radius * 0.5, 0, Math.PI * 2);
  ctx.fillStyle = '#fff';
  ctx.fill();
  
  // Draw legend below - improved layout
  const legendY = height - 40;
  const legendStartY = legendY - 10;
  const itemsPerRow = 2;
  const legendItemWidth = width / itemsPerRow;
  const rowHeight = 20;
  
  data.forEach((value, index) => {
    const row = Math.floor(index / itemsPerRow);
    const col = index % itemsPerRow;
    const x = col * legendItemWidth + 10;
    const y = legendStartY + (row * rowHeight);
    
    // Color dot
    ctx.beginPath();
    ctx.arc(x, y, 5, 0, Math.PI * 2);
    ctx.fillStyle = colors[index];
    ctx.fill();
    
    // Label
    ctx.fillStyle = '#495057';
    ctx.font = '11px Outfit';
    ctx.textAlign = 'left';
    ctx.fillText(`${labels[index]} (${Math.round(value/total*100)}%)`, x + 12, y + 4);
  });
}

// ============================================
// Dashboard Functionality
// ============================================
function initDashboard() {
  // Check if on dashboard page
  const dashboardSidebar = document.querySelector('.dashboard-sidebar');
  if (!dashboardSidebar) return;
  
  // Load user info
  const user = checkAuth();
  if (user) {
    const nameEl = document.querySelector('.user-info h5');
    const roleEl = document.querySelector('.user-info p');
    
    if (nameEl) nameEl.textContent = user.name || user.email.split('@')[0];
    if (roleEl) roleEl.textContent = user.role ? user.role.charAt(0).toUpperCase() + user.role.slice(1) : 'User';
  }

  // Sidebar toggle for mobile
  const sidebarToggle = document.querySelector('.sidebar-toggle');
  const sidebar = document.querySelector('.dashboard-sidebar');
  
  if (sidebarToggle && sidebar) {
    sidebarToggle.addEventListener('click', function() {
      sidebar.classList.toggle('active');
    });
  }

  // Logout buttons
  document.querySelectorAll('a[href="index.html"]').forEach(link => {
    if (link.textContent.includes('Logout') || link.closest('.dashboard-nav-link')?.textContent.includes('Logout')) {
      link.addEventListener('click', function(e) {
        e.preventDefault();
        logout();
      });
    }
  });
  
  // Initialize "Save Changes" button handlers
  initSaveButtonHandlers();
}

// ============================================
// Universal Button Handlers
// ============================================
function initSaveButtonHandlers() {
  // Find all buttons with "Save" text
  const saveButtons = Array.from(document.querySelectorAll('button')).filter(btn => 
    btn.textContent.includes('Save Changes') || 
    btn.textContent.includes('Save Settings') ||
    btn.textContent.includes('Save Preferences') ||
    btn.textContent.includes('Update Password')
  );
  
  saveButtons.forEach(btn => {
    const form = btn.closest('form');
    
    if (form && !form.dataset.handlerAttached) {
      form.dataset.handlerAttached = 'true';
      form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Disable the button
        btn.disabled = true;
        btn.classList.add('loading');
        
        const originalText = btn.textContent;
        btn.textContent = 'Saving...';
        
        // Simulate save operation
        setTimeout(() => {
          btn.classList.remove('loading');
          btn.textContent = 'Saved!';
          showNotification('Changes saved successfully!', 'success');
          
          // Re-enable after 2 seconds
          setTimeout(() => {
            btn.disabled = false;
            btn.textContent = originalText;
          }, 2000);
        }, 1000);
      });
    }
  });
}

// ============================================
// Universal Interactive Buttons
// ============================================
function initInteractiveButtons() {
  // Add click effect to all buttons
  document.addEventListener('click', function(e) {
    const btn = e.target.closest('.btn, button');
    if (btn && !btn.disabled) {
      btn.style.transition = 'transform 0.1s ease, box-shadow 0.1s ease';
    }
  });
  
  // Filter buttons
  const filterButtons = document.querySelectorAll('.inquiry-filter-btn, .property-filter-btn');
  filterButtons.forEach(btn => {
    btn.addEventListener('click', function() {
      // Visual feedback
      this.style.transform = 'scale(0.98)';
      setTimeout(() => {
        this.style.transform = '';
      }, 100);
    });
  });
  
  // Action buttons (Approve, Reject, Delete, etc.)
  const actionButtons = document.querySelectorAll('.action-btn');
  actionButtons.forEach(btn => {
    if (!btn.dataset.handlerAttached) {
      btn.dataset.handlerAttached = 'true';
      btn.addEventListener('click', function(e) {
        if (this.disabled) return;
        
        // Add visual feedback
        this.style.opacity = '0.6';
        this.style.transform = 'scale(0.95)';
        
        setTimeout(() => {
          this.style.opacity = '';
          this.style.transform = '';
        }, 200);
      });
    }
  });
  
  // Search and submit buttons
  const submitButtons = document.querySelectorAll('button[type="submit"]:not([data-no-feedback])');
  submitButtons.forEach(btn => {
    if (!btn.dataset.feedbackAttached) {
      btn.dataset.feedbackAttached = 'true';
      const form = btn.closest('form');
      if (form) {
        form.addEventListener('submit', function(e) {
          if (!btn.disabled) {
            btn.classList.add('loading');
            setTimeout(() => {
              btn.classList.remove('loading');
            }, 1500);
          }
        });
      }
    }
  });
}

// ============================================
// Customer Dashboard
// ============================================
function initCustomerDashboard() {
  if (!window.location.pathname.includes('customer-dashboard')) return;
  
  // Load saved properties dynamically
  loadSavedProperties();
  
  // Load recently viewed properties
  loadRecentlyViewed();
  
  // Load saved properties count
  const favorites = JSON.parse(localStorage.getItem('flatfinders_favorites') || '[]');
  const savedCountEl = document.querySelector('.stat-card:first-child h4');
  if (savedCountEl) {
    savedCountEl.textContent = favorites.length;
  }
  
  // Load inquiries count
  const inquiries = JSON.parse(localStorage.getItem('flatfinders_inquiries') || '[]');
  const user = checkAuth();
  const userInquiries = inquiries.filter(i => i.email === user?.email);
  const inquiriesCountEl = document.querySelector('.stat-card:nth-child(2) h4');
  if (inquiriesCountEl) {
    inquiriesCountEl.textContent = userInquiries.length;
  }
  
  // Load properties viewed count
  const recentlyViewed = JSON.parse(localStorage.getItem('flatfinders_recently_viewed') || '[]');
  const viewedCountEl = document.querySelector('.stat-card:nth-child(4) h4');
  if (viewedCountEl) {
    viewedCountEl.textContent = recentlyViewed.length;
  }
}

function loadSavedProperties() {
  const container = document.querySelector('.dashboard-card-body');
  if (!container) return;
  
  // Check if we're on the saved properties section
  const header = container.previousElementSibling;
  if (!header || !header.textContent.includes('Saved Properties')) return;
  
  const favorites = JSON.parse(localStorage.getItem('flatfinders_favorites') || '[]');
  const favoritesData = JSON.parse(localStorage.getItem('flatfinders_favorites_data') || '{}');
  
  // Clear existing content
  container.innerHTML = '';
  
  if (favorites.length === 0) {
    container.innerHTML = `
      <div style="text-align: center; padding: 3rem; color: var(--gray-600);">
        <svg viewBox="0 0 24 24" style="width: 64px; height: 64px; fill: var(--gray-300); margin-bottom: 1rem;">
          <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
        </svg>
        <h3 style="margin-bottom: 0.5rem;">No saved properties yet</h3>
        <p>Start browsing and save properties you're interested in</p>
        <a href="properties.html" class="btn btn-primary" style="margin-top: 1rem;">Browse Properties</a>
      </div>
    `;
    return;
  }
  
  // Display saved properties
  favorites.forEach(id => {
    const property = favoritesData[id];
    if (!property) return;
    
    const locationText = property.locationText || (property.location.charAt(0).toUpperCase() + property.location.slice(1) + ', Dhaka');
    
    const propertyCard = document.createElement('div');
    propertyCard.className = 'saved-property-card';
    propertyCard.dataset.id = id;
    propertyCard.style.animation = 'fadeIn 0.3s ease';
    propertyCard.innerHTML = `
      <img src="${property.image}" alt="${property.title}" class="saved-property-image">
      <div class="saved-property-content">
        <div class="saved-property-price">৳${parseInt(property.price).toLocaleString()} <span style="font-size: 0.8rem; font-weight: 400; color: var(--gray-500);">/month</span></div>
        <h4 class="saved-property-title">${property.title}</h4>
        <div class="saved-property-location">
          <svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
          ${locationText}
        </div>
        <div class="saved-property-actions">
          <a href="property-detail.html" class="btn btn-sm btn-primary">View Details</a>
          <button class="btn btn-sm btn-secondary" onclick="removeFromFavorites('${id}')">Remove</button>
        </div>
      </div>
    `;
    
    container.appendChild(propertyCard);
  });
}

function removeFromFavorites(propertyId) {
  let favorites = JSON.parse(localStorage.getItem('flatfinders_favorites') || '[]');
  let favoritesData = JSON.parse(localStorage.getItem('flatfinders_favorites_data') || '{}');
  
  // Remove from arrays
  favorites = favorites.filter(id => id !== propertyId);
  delete favoritesData[propertyId];
  
  // Save back to localStorage
  localStorage.setItem('flatfinders_favorites', JSON.stringify(favorites));
  localStorage.setItem('flatfinders_favorites_data', JSON.stringify(favoritesData));
  
  // Update UI
  const card = document.querySelector(`.saved-property-card[data-id="${propertyId}"]`);
  if (card) {
    card.style.animation = 'fadeOut 0.3s ease forwards';
    setTimeout(() => {
      card.remove();
      
      // Update count
      const savedCountEl = document.querySelector('.stat-card:first-child h4');
      if (savedCountEl) {
        savedCountEl.textContent = favorites.length;
      }
      
      // Reload if no properties left
      if (favorites.length === 0) {
        loadSavedProperties();
      }
    }, 300);
  }
  
  // Update heart icon on properties page
  const heartBtn = document.querySelector(`[data-id="${propertyId}"] .property-favorite`);
  if (heartBtn) {
    heartBtn.classList.remove('active');
  }
  
  updateFavoritesCount();
  showNotification('Property removed from favorites', 'info');
}

// ============================================
// Recently Viewed Properties
// ============================================
function trackRecentlyViewed() {
  // Only track on property detail page
  if (!window.location.pathname.includes('property-detail')) return;
  
  // Get property ID from URL or generate one
  const urlParams = new URLSearchParams(window.location.search);
  const propertyId = urlParams.get('id') || '1'; // Default to 1 for demo
  
  // Get property details from page
  const propertyTitle = document.querySelector('.property-info h1')?.textContent || 'Property';
  const propertyPrice = document.querySelector('.property-price')?.textContent || '0';
  const propertyLocation = document.querySelector('.property-location span')?.textContent || 'Dhaka';
  const propertyImage = document.querySelector('.gallery-main img')?.src || '';
  const propertyType = document.querySelector('.property-details-list li')?.textContent?.includes('Bachelor') ? 'bachelor' : 'apartment';
  
  // Get or create recently viewed list
  let recentlyViewed = JSON.parse(localStorage.getItem('flatfinders_recently_viewed') || '[]');
  
  // Remove if already exists (to add to top)
  recentlyViewed = recentlyViewed.filter(item => item.id !== propertyId);
  
  // Add to beginning
  recentlyViewed.unshift({
    id: propertyId,
    title: propertyTitle,
    price: propertyPrice.replace(/[^0-9]/g, ''),
    location: propertyLocation,
    image: propertyImage,
    type: propertyType,
    viewedAt: new Date().toISOString()
  });
  
  // Keep only last 20 viewed properties
  if (recentlyViewed.length > 20) {
    recentlyViewed = recentlyViewed.slice(0, 20);
  }
  
  localStorage.setItem('flatfinders_recently_viewed', JSON.stringify(recentlyViewed));
}

function loadRecentlyViewed() {
  const recentSection = document.querySelector('.recently-viewed-section');
  if (!recentSection) return;
  
  const recentlyViewed = JSON.parse(localStorage.getItem('flatfinders_recently_viewed') || '[]');
  const container = recentSection.querySelector('.property-grid');
  if (!container) return;
  
  // Clear any demo data
  const demoCards = container.querySelectorAll('[data-id^="demo-"]');
  demoCards.forEach(card => card.remove());
  
  if (recentlyViewed.length === 0) {
    // Show message if no recently viewed properties
    if (container.children.length === 0) {
      container.innerHTML = `
        <div style="grid-column: 1 / -1; text-align: center; padding: 2rem; color: var(--gray-600);">
          <p>No recently viewed properties</p>
          <a href="properties.html" class="btn btn-primary" style="margin-top: 1rem;">Browse Properties</a>
        </div>
      `;
    }
    return;
  }
  
  // Display first 3-6 recently viewed
  const displayCount = Math.min(recentlyViewed.length, 6);
  
  for (let i = 0; i < displayCount; i++) {
    const property = recentlyViewed[i];
    if (!property) continue;
    
    const card = document.createElement('div');
    card.className = 'property-card';
    card.dataset.id = property.id;
    card.dataset.price = property.price;
    card.dataset.location = property.location.toLowerCase().replace(/, dhaka/i, '');
    card.dataset.type = property.type;
    card.style.animation = 'fadeIn 0.3s ease';
    card.innerHTML = `
      <div class="property-image">
        <img src="${property.image}" alt="${property.title}">
        <span class="property-badge ${property.type === 'bachelor' ? 'bachelor' : ''}">
          ${property.type === 'bachelor' ? 'Bachelor Flat' : 'For Rent'}
        </span>
        <button class="property-favorite" aria-label="Add to favorites">
          <svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
        </button>
      </div>
      <div class="property-content">
        <div class="property-price">৳${parseInt(property.price).toLocaleString()} <span>/month</span></div>
        <h3 class="property-title">${property.title}</h3>
        <div class="property-location">
          <svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
          ${property.location}
        </div>
      </div>
    `;
    
    container.appendChild(card);
  }
  
  // Re-initialize favorites for newly added cards
  initFavorites();
  loadFavorites();
}

// ============================================
// Owner Dashboard
// ============================================
function initOwnerDashboard() {
  if (!window.location.pathname.includes('owner-dashboard')) return;
  
  const user = checkAuth();
  
  // Load owner's properties
  const properties = JSON.parse(localStorage.getItem('flatfinders_properties') || '[]');
  const ownerProperties = properties.filter(p => p.ownerEmail === user?.email);
  
  // Update stats
  const totalPropsEl = document.querySelector('.stat-card:first-child h4');
  if (totalPropsEl) {
    totalPropsEl.textContent = ownerProperties.length;
  }
  
  const activePropsEl = document.querySelector('.stat-card:nth-child(2) h4');
  if (activePropsEl) {
    activePropsEl.textContent = ownerProperties.filter(p => p.status === 'approved').length;
  }
  
  // Load inquiries for owner
  const inquiries = JSON.parse(localStorage.getItem('flatfinders_inquiries') || '[]');
  const ownerInquiries = inquiries.filter(i => {
    return ownerProperties.some(p => p.id === i.propertyId);
  });
  
  const inquiriesCountEl = document.querySelector('.stat-card:nth-child(3) h4');
  if (inquiriesCountEl) {
    inquiriesCountEl.textContent = ownerInquiries.length;
  }
  
  // Edit/Delete property buttons
  document.querySelectorAll('.action-btn.edit').forEach(btn => {
    btn.addEventListener('click', function() {
      showNotification('Edit functionality - Opening editor...', 'info');
      // Could open a modal for editing
    });
  });
  
  document.querySelectorAll('.action-btn.delete').forEach(btn => {
    btn.addEventListener('click', function() {
      if (confirm('Are you sure you want to delete this property?')) {
        const row = this.closest('tr');
        if (row) {
          row.style.animation = 'fadeOut 0.3s ease forwards';
          setTimeout(() => {
            row.remove();
            showNotification('Property deleted successfully', 'success');
          }, 300);
        }
      }
    });
  });
}

// ============================================
// Admin Dashboard
// ============================================
function initAdminDashboard() {
  if (!window.location.pathname.includes('admin')) return;
  
  // Property approval/rejection
  document.querySelectorAll('.action-btn.edit[title="Approve"]').forEach(btn => {
    btn.addEventListener('click', function() {
      const row = this.closest('tr');
      const statusBadge = row?.querySelector('.status-badge');
      if (statusBadge) {
        statusBadge.textContent = 'Approved';
        statusBadge.className = 'status-badge approved';
      }
      showNotification('Property approved successfully!', 'success');
    });
  });

  document.querySelectorAll('.action-btn.delete[title="Reject"]').forEach(btn => {
    btn.addEventListener('click', function() {
      const row = this.closest('tr');
      const statusBadge = row?.querySelector('.status-badge');
      if (statusBadge) {
        statusBadge.textContent = 'Rejected';
        statusBadge.className = 'status-badge rejected';
      }
      showNotification('Property rejected', 'info');
    });
  });

  // Delete buttons
  document.querySelectorAll('.action-btn.delete[title="Delete"]').forEach(btn => {
    btn.addEventListener('click', function() {
      if (confirm('Are you sure you want to delete this item?')) {
        const row = this.closest('tr');
        if (row) {
          row.style.animation = 'fadeOut 0.3s ease forwards';
          setTimeout(() => row.remove(), 300);
          showNotification('Item deleted successfully', 'success');
        }
      }
    });
  });
}

// ============================================
// Utility Functions
// ============================================
function formatPrice(price) {
  return new Intl.NumberFormat('en-BD', {
    style: 'currency',
    currency: 'BDT',
    minimumFractionDigits: 0
  }).format(price);
}

function formatDate(date) {
  return new Intl.DateTimeFormat('en-BD', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  }).format(new Date(date));
}

// Debounce function
function debounce(func, wait) {
  let timeout;
  return function executedFunction(...args) {
    const later = () => {
      clearTimeout(timeout);
      func(...args);
    };
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
  };
}

// ============================================
// Notification System
// ============================================
function initNotifications() {
  const notificationIcon = document.querySelector('.notifications');
  if (!notificationIcon) return;
  
  // Create notification dropdown if it doesn't exist
  let dropdown = document.querySelector('.notification-dropdown');
  if (!dropdown) {
    dropdown = document.createElement('div');
    dropdown.className = 'notification-dropdown';
    dropdown.innerHTML = `
      <div class="notification-dropdown-header">
        <h4>Notifications</h4>
        <span class="mark-all-read" onclick="markAllNotificationsRead()">Mark all as read</span>
      </div>
      <div class="notification-list" id="notificationList"></div>
    `;
    document.querySelector('.dashboard-header').appendChild(dropdown);
  }
  
  // Toggle dropdown
  notificationIcon.addEventListener('click', function(e) {
    e.stopPropagation();
    dropdown.classList.toggle('active');
    loadNotifications();
  });
  
  // Close dropdown when clicking outside
  document.addEventListener('click', function(e) {
    if (!dropdown.contains(e.target) && !notificationIcon.contains(e.target)) {
      dropdown.classList.remove('active');
    }
  });
  
  // Load initial notification count
  updateNotificationBadge();
}

function loadNotifications() {
  const notificationList = document.getElementById('notificationList');
  if (!notificationList) return;
  
  // Get notifications from localStorage or use sample data
  let notifications = JSON.parse(localStorage.getItem('notifications') || '[]');
  
  // Add sample notifications if empty
  if (notifications.length === 0) {
    const userRole = checkAuth()?.role || 'customer';
    notifications = getSampleNotifications(userRole);
    localStorage.setItem('notifications', JSON.stringify(notifications));
  }
  
  if (notifications.length === 0) {
    notificationList.innerHTML = `
      <div class="notification-empty">
        <svg viewBox="0 0 24 24"><path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
        <p>No notifications yet</p>
      </div>
    `;
  } else {
    notificationList.innerHTML = notifications.map((notif, index) => `
      <div class="notification-item ${notif.read ? '' : 'unread'}" onclick="markNotificationRead(${index})">
        <div class="notification-item-header">
          <span class="notification-title">${notif.title}</span>
          <span class="notification-time">${notif.time}</span>
        </div>
        <div class="notification-message">${notif.message}</div>
      </div>
    `).join('');
  }
}

function getSampleNotifications(role) {
  const now = new Date();
  const notifications = [];
  
  if (role === 'owner') {
    notifications.push(
      {
        title: 'New Inquiry',
        message: 'John Doe sent an inquiry about Modern Bachelor Flat with Balcony',
        time: '5 min ago',
        read: false
      },
      {
        title: 'New Inquiry',
        message: 'Ahmed Hassan asked about Cozy Bachelor Room Near AIUB',
        time: '2 hours ago',
        read: false
      },
      {
        title: 'Property Approved',
        message: 'Your property "Spacious 2BHK Family Apartment" has been approved',
        time: 'Yesterday',
        read: true
      }
    );
  } else if (role === 'customer') {
    notifications.push(
      {
        title: 'Inquiry Reply',
        message: 'Fatima Khan replied to your inquiry about Modern Bachelor Flat',
        time: '1 hour ago',
        read: false
      },
      {
        title: 'Price Drop',
        message: 'Price reduced on saved property: Premium Bachelor Suite',
        time: '3 hours ago',
        read: false
      },
      {
        title: 'New Listing',
        message: 'New bachelor flat available in Dhanmondi matching your preferences',
        time: 'Yesterday',
        read: true
      }
    );
  } else if (role === 'admin') {
    notifications.push(
      {
        title: 'Pending Approval',
        message: '3 new properties waiting for approval',
        time: '10 min ago',
        read: false
      },
      {
        title: 'New User',
        message: '5 new users registered today',
        time: '1 hour ago',
        read: false
      },
      {
        title: 'System Update',
        message: 'Platform analytics report is ready',
        time: '2 hours ago',
        read: true
      }
    );
  }
  
  return notifications;
}

function markNotificationRead(index) {
  const notifications = JSON.parse(localStorage.getItem('notifications') || '[]');
  if (notifications[index]) {
    notifications[index].read = true;
    localStorage.setItem('notifications', JSON.stringify(notifications));
    loadNotifications();
    updateNotificationBadge();
  }
}

function markAllNotificationsRead() {
  const notifications = JSON.parse(localStorage.getItem('notifications') || '[]');
  notifications.forEach(notif => notif.read = true);
  localStorage.setItem('notifications', JSON.stringify(notifications));
  loadNotifications();
  updateNotificationBadge();
  showNotification('All notifications marked as read', 'success');
}

function updateNotificationBadge() {
  const badge = document.querySelector('.notifications .badge');
  if (!badge) return;
  
  const notifications = JSON.parse(localStorage.getItem('notifications') || '[]');
  const unreadCount = notifications.filter(n => !n.read).length;
  
  if (unreadCount > 0) {
    badge.style.display = 'block';
  } else {
    badge.style.display = 'none';
  }
}

function addNotification(title, message) {
  const notifications = JSON.parse(localStorage.getItem('notifications') || '[]');
  notifications.unshift({
    title: title,
    message: message,
    time: 'Just now',
    read: false
  });
  // Keep only last 20 notifications
  if (notifications.length > 20) {
    notifications.pop();
  }
  localStorage.setItem('notifications', JSON.stringify(notifications));
  updateNotificationBadge();
}

// Export functions for use in HTML
window.sortProperties = sortProperties;
window.toggleView = toggleView;
window.filterProperties = filterProperties;
window.logout = logout;
window.checkAuth = checkAuth;
window.showNotification = showNotification;
window.markNotificationRead = markNotificationRead;
window.markAllNotificationsRead = markAllNotificationsRead;
window.addNotification = addNotification;
window.removeFromFavorites = removeFromFavorites;
window.loadSavedProperties = loadSavedProperties;
