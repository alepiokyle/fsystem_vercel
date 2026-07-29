/**
 * Sidebar Shrink Functionality
 * Handles the sidebar shrinking when clicking popup or toggle button
 */

(function() {
    'use strict';

    // Configuration
    const config = {
        sidebarSelector: '.pc-sidebar',
        toggleButtonSelector: '.sidebar-toggle-btn',
        popupSelector: '.sidebar-popup',
        transitionDuration: 300
    };

    // Sidebar shrink manager
    const SidebarShrinkManager = {
        init: function() {
            this.bindEvents();
            this.setupToggleButton();
        },

        bindEvents: function() {
            // Toggle button click
            document.addEventListener('click', (e) => {
                if (e.target.matches('.sidebar-toggle-btn, .sidebar-toggle-btn *')) {
                    e.preventDefault();
                    this.toggleSidebar();
                }
            });

            // Sidebar popup click to trigger shrink
            document.addEventListener('click', (e) => {
                if (e.target.matches('.sidebar-popup, .sidebar-popup *')) {
                    // Optional: Auto-shrink when popup is clicked
                    if (!this.isSidebarShrunk()) {
                        this.toggleSidebar();
                    }
                }
            });

            // Keyboard shortcut (Ctrl + B)
            document.addEventListener('keydown', (e) => {
                if (e.ctrlKey && e.key === 'b') {
                    e.preventDefault();
                    this.toggleSidebar();
                }
            });
        },

        setupToggleButton: function() {
            const toggleBtn = document.querySelector(config.toggleButtonSelector);
            if (toggleBtn) {
                toggleBtn.addEventListener('click', () => this.toggleSidebar());
            }
        },

        toggleSidebar: function() {
            const sidebar = document.querySelector(config.sidebarSelector);
            if (!sidebar) return;

            sidebar.classList.toggle('sidebar-shrink');
            
            // Update toggle button icon
            const toggleBtn = document.querySelector(config.toggleButtonSelector);
            if (toggleBtn) {
                const icon = toggleBtn.querySelector('i');
                if (icon) {
                    icon.className = this.isSidebarShrunk() ? 'ti ti-chevron-right' : 'ti ti-chevron-left';
                }
            }

            // Update popup positions
            this.updatePopupPositions();
            
            // Dispatch custom event
            const event = new CustomEvent('sidebarShrinkToggled', {
                detail: { isShrunk: this.isSidebarShrunk() }
            });
            document.dispatchEvent(event);
        },

        isSidebarShrunk: function() {
            const sidebar = document.querySelector(config.sidebarSelector);
            return sidebar && sidebar.classList.contains('sidebar-shrink');
        },

        updatePopupPositions: function() {
            const popups = document.querySelectorAll(config.popupSelector);
            const isShrunk = this.isSidebarShrunk();
            const sidebarWidth = isShrunk ? 70 : 250;

            popups.forEach(popup => {
                popup.style.left = `${sidebarWidth + 10}px`;
            });
        }
    };

    // Initialize when DOM is ready
    function initialize() {
        SidebarShrinkManager.init();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initialize);
    } else {
        initialize();
    }

    // Expose globally
    window.SidebarShrinkManager = SidebarShrinkManager;

})();
