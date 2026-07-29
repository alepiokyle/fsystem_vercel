/**
 * Sidebar Popup Positioning Fix
 * Ensures popups and dropdowns follow sidebar shrinking behavior
 */

(function() {
    'use strict';

    // Configuration
    const config = {
        sidebarSelector: '.sidebar, .pc-sidebar',
        popupSelector: '.sidebar-popup, .dropdown-menu, .pc-submenu, .pc-hasmenu .pc-submenu',
        expandedWidth: 250,
        collapsedWidth: 70,
        transitionDuration: 300
    };

    // Utility functions
    const utils = {
        isSidebarCollapsed: function() {
            const sidebar = document.querySelector(config.sidebarSelector);
            return sidebar && (sidebar.classList.contains('sidebar-collapsed') || 
                   sidebar.classList.contains('pc-sidebar-collapse'));
        },

        updatePopupPositions: function() {
            const popups = document.querySelectorAll(config.popupSelector);
            const isCollapsed = this.isSidebarCollapsed();
            const sidebarWidth = isCollapsed ? config.collapsedWidth : config.expandedWidth;

            popups.forEach(popup => {
                // Update left position based on sidebar state
                popup.style.left = `${sidebarWidth + 10}px`;
                
                // Add transition class
                popup.classList.add('popup-transition');
            });
        },

        debounce: function(func, wait) {
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
    };

    // Main handler
    const SidebarPopupManager = {
        init: function() {
            this.bindEvents();
            this.updatePositions();
        },

        bindEvents: function() {
            // Listen for sidebar toggle events
            const sidebarToggle = document.querySelector('.sidebar-toggle, .pc-toggle-sidebar');
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', () => {
                    setTimeout(() => utils.updatePopupPositions(), config.transitionDuration);
                });
            }

            // Listen for window resize
            window.addEventListener('resize', utils.debounce(() => {
                utils.updatePopupPositions();
            }, 100));

            // Listen for custom sidebar events
            document.addEventListener('sidebarToggled', () => {
                utils.updatePopupPositions();
            });

            // Monitor sidebar state changes
            this.observeSidebarChanges();
        },

        observeSidebarChanges: function() {
            const sidebar = document.querySelector(config.sidebarSelector);
            if (!sidebar) return;

            // Create observer for class changes
            const observer = new MutationObserver((mutations) => {
                mutations.forEach((mutation) => {
                    if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                        setTimeout(() => utils.updatePopupPositions(), 50);
                    }
                });
            });

            observer.observe(sidebar, {
                attributes: true,
                attributeFilter: ['class']
            });
        },

        updatePositions: function() {
            utils.updatePopupPositions();
        }
    };

    // Initialize when DOM is ready
    function initialize() {
        SidebarPopupManager.init();
    }

    // DOM ready check
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initialize);
    } else {
        initialize();
    }

    // Expose globally for manual triggering
    window.SidebarPopupManager = SidebarPopupManager;

})();

// Additional utility for manual positioning
function fixSidebarPopupPosition(popupElement) {
    if (!popupElement) return;

    const sidebar = document.querySelector('.sidebar, .pc-sidebar');
    if (!sidebar) return;

    const isCollapsed = sidebar.classList.contains('sidebar-collapsed') || 
                       sidebar.classList.contains('pc-sidebar-collapse');
    
    const sidebarWidth = isCollapsed ? 70 : 250;
    popupElement.style.left = `${sidebarWidth + 10}px`;
    popupElement.style.transition = 'left 0.3s ease';
}

// Auto-fix popups on page load
document.addEventListener('DOMContentLoaded', function() {
    const popups = document.querySelectorAll('.sidebar-popup, .dropdown-menu, .pc-submenu');
    popups.forEach(fixSidebarPopupPosition);
});
