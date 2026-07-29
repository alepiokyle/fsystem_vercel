// Mobile Responsive JavaScript for Laravel Dashboard Application

document.addEventListener("DOMContentLoaded", function () {
    // Mobile sidebar toggle functionality
    const mobileMenuToggle = document.getElementById("mobile-collapse");
    const sidebar = document.querySelector(".pc-sidebar");
    const overlay = document.createElement("div");

    // Create overlay element
    overlay.className = "mobile-overlay";
    document.body.appendChild(overlay);

    // Mobile menu toggle event
    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener("click", function (e) {
            e.preventDefault();
            toggleMobileSidebar();
        });
    }

    // Overlay click to close sidebar
    overlay.addEventListener("click", function () {
        closeMobileSidebar();
    });

    // Close button for mobile sidebar
    const closeButton = document.querySelector(".mobile-sidebar-close");
    if (closeButton) {
        closeButton.addEventListener("click", function () {
            closeMobileSidebar();
        });
    }

    // Handle window resize
    window.addEventListener("resize", function () {
        if (window.innerWidth >= 768) {
            closeMobileSidebar();
        }
    });

    // Touch gesture support for mobile
    let touchStartX = 0;
    let touchEndX = 0;

    document.addEventListener("touchstart", function (e) {
        touchStartX = e.changedTouches[0].screenX;
    });

    document.addEventListener("touchend", function (e) {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
    });

    function handleSwipe() {
        const swipeThreshold = 50;
        const swipeLength = touchEndX - touchStartX;

        // Swipe right to open sidebar
        if (swipeLength > swipeThreshold && touchStartX < 50) {
            openMobileSidebar();
        }
        // Swipe left to close sidebar
        else if (swipeLength < -swipeThreshold) {
            closeMobileSidebar();
        }
    }

    function toggleMobileSidebar() {
        if (sidebar.classList.contains("mobile-show")) {
            closeMobileSidebar();
        } else {
            openMobileSidebar();
        }
    }

    function openMobileSidebar() {
        sidebar.classList.add("mobile-show");
        overlay.classList.add("show");
        document.body.style.overflow = "hidden";
    }

    function closeMobileSidebar() {
        sidebar.classList.remove("mobile-show");
        overlay.classList.remove("show");
        document.body.style.overflow = "";
    }

    // Mobile table responsiveness
    const tables = document.querySelectorAll(".table:not(.table-mobile-stack)");
    tables.forEach(function (table) {
        if (window.innerWidth < 768) {
            makeTableMobileResponsive(table);
        }
    });

    function makeTableMobileResponsive(table) {
        const headers = Array.from(table.querySelectorAll("th")).map((th) =>
            th.textContent.trim()
        );
        const rows = table.querySelectorAll("tbody tr");

        rows.forEach(function (row) {
            const cells = row.querySelectorAll("td");
            cells.forEach(function (cell, index) {
                if (headers[index]) {
                    cell.setAttribute("data-label", headers[index]);
                }
            });
        });

        table.classList.add("table-mobile-stack");
    }

    // Mobile form enhancements
    const forms = document.querySelectorAll("form");
    forms.forEach(function (form) {
        // Prevent zoom on input focus for iOS
        const inputs = form.querySelectorAll("input, select, textarea");
        inputs.forEach(function (input) {
            input.addEventListener("focus", function () {
                // Add viewport meta tag adjustment if needed
                const viewport = document.querySelector(
                    'meta[name="viewport"]'
                );
                if (viewport) {
                    viewport.setAttribute(
                        "content",
                        "width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui, maximum-scale=1.0"
                    );
                }
            });

            input.addEventListener("blur", function () {
                // Reset viewport
                const viewport = document.querySelector(
                    'meta[name="viewport"]'
                );
                if (viewport) {
                    viewport.setAttribute(
                        "content",
                        "width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui"
                    );
                }
            });
        });
    });

    // Mobile dropdown enhancements
    const dropdowns = document.querySelectorAll(".dropdown");
    dropdowns.forEach(function (dropdown) {
        const toggle = dropdown.querySelector(".dropdown-toggle");
        if (toggle) {
            toggle.addEventListener("click", function (e) {
                if (window.innerWidth < 768) {
                    e.preventDefault();
                    const menu = dropdown.querySelector(".dropdown-menu");
                    if (menu) {
                        menu.classList.toggle("show");
                    }
                }
            });
        }
    });

    // Mobile modal enhancements
    const modals = document.querySelectorAll(".modal");
    modals.forEach(function (modal) {
        // Close modal when clicking outside on mobile
        modal.addEventListener("click", function (e) {
            if (e.target === modal) {
                const bsModal = bootstrap.Modal.getInstance(modal);
                if (bsModal) {
                    bsModal.hide();
                }
            }
        });
    });

    // Mobile search functionality
    const mobileSearchToggle = document.querySelector(
        ".d-inline-flex.d-md-none .pc-head-link"
    );
    if (mobileSearchToggle) {
        mobileSearchToggle.addEventListener("click", function (e) {
            e.preventDefault();
            const searchDropdown = document.querySelector(".drp-search");
            if (searchDropdown) {
                searchDropdown.classList.toggle("show");
            }
        });
    }

    // Mobile chart responsiveness
    const charts = document.querySelectorAll(".chart-container canvas");
    charts.forEach(function (canvas) {
        if (window.innerWidth < 768) {
            // Make charts responsive
            canvas.style.maxWidth = "100%";
            canvas.style.height = "auto";
        }
    });

    // Mobile loading states
    function showMobileLoader() {
        const loader = document.createElement("div");
        loader.className = "mobile-loader";
        loader.innerHTML = `
            <div class="mobile-loader-backdrop"></div>
            <div class="mobile-loader-content">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2">Loading...</p>
            </div>
        `;
        document.body.appendChild(loader);
        return loader;
    }

    function hideMobileLoader(loader) {
        if (loader && loader.parentNode) {
            loader.parentNode.removeChild(loader);
        }
    }

    // Add mobile loader styles dynamically
    const style = document.createElement("style");
    style.textContent = `
        .mobile-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .mobile-loader-backdrop {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
        }
        .mobile-loader-content {
            position: relative;
            background: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .mobile-loader-content .spinner-border {
            width: 2rem;
            height: 2rem;
        }
    `;
    document.head.appendChild(style);

    // Export functions for global use
    window.MobileResponsive = {
        showLoader: showMobileLoader,
        hideLoader: hideMobileLoader,
        toggleSidebar: toggleMobileSidebar,
        openSidebar: openMobileSidebar,
        closeSidebar: closeMobileSidebar,
    };

    // Initialize on page load
    if (window.innerWidth < 768) {
        // Add mobile-specific classes
        document.body.classList.add("mobile-view");

        // Initialize mobile features
        console.log("Mobile responsive features initialized");
    }

    // Handle orientation changes
    window.addEventListener("orientationchange", function () {
        // Small delay to allow orientation to complete
        setTimeout(function () {
            // Reinitialize mobile features if needed
            if (window.innerWidth < 768) {
                closeMobileSidebar();
            }
        }, 500);
    });

    // Accessibility improvements
    // Add skip links for mobile
    const skipLink = document.createElement("a");
    skipLink.href = "#main-content";
    skipLink.className = "skip-link";
    document.body.insertBefore(skipLink, document.body.firstChild);

    // Focus management for mobile sidebar
    const sidebarLinks = document.querySelectorAll(".pc-sidebar .pc-link");
    sidebarLinks.forEach(function (link) {
        link.addEventListener("click", function () {
            if (window.innerWidth < 768) {
                closeMobileSidebar();
            }
        });
    });

    // Keyboard navigation support
    document.addEventListener("keydown", function (e) {
        // Escape key closes mobile sidebar
        if (e.key === "Escape" && sidebar.classList.contains("mobile-show")) {
            closeMobileSidebar();
        }
    });
});
