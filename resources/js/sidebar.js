
(function() {
    const sidebarState = localStorage.getItem('sidebarState');
    if (sidebarState === 'collapsed') {
        document.body.classList.add('sidebar-toggled');
    }
})();

document.addEventListener('DOMContentLoaded', function() {
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarToggleTop = document.getElementById('sidebarToggleTop');
    const body = document.body;
    const sidebar = document.querySelector('.sidebar');
    
    if (body.classList.contains('sidebar-toggled') && sidebarToggle) {
        const icon = sidebarToggle.querySelector('i');
        if (icon) {
            icon.classList.remove('bi-chevron-left');
            icon.classList.add('bi-chevron-right');
        }
    }
    
    function setActiveNavItem() {
        const currentUrl = window.location.href;
        
        document.querySelectorAll('.sidebar .nav-item').forEach(item => {
            item.classList.remove('active');
        });
        
        document.querySelectorAll('.sidebar .nav-link').forEach(link => {
            link.classList.remove('active');
        });
        
        document.querySelectorAll('.sidebar .submenu-item').forEach(item => {
            item.classList.remove('active');
        });
        
        if (currentUrl.includes('barang-keluar')) {
            const barangKeluarNavItem = document.querySelector('.nav-item:has([data-target="#collapseBarangKeluar"])');
            if (barangKeluarNavItem) {
                barangKeluarNavItem.classList.add('active');
                barangKeluarNavItem.classList.add('open'); 
                const navLink = barangKeluarNavItem.querySelector('.nav-link');
                if (navLink) navLink.classList.add('active');
                
                const submenu = document.querySelector('#collapseBarangKeluar');
                if (submenu) {
                    submenu.classList.add('show');
                }
            }
            
            let activeSubmenuItem = null;
            if (currentUrl.includes('barang-keluar/create')) {
                activeSubmenuItem = document.querySelector('.submenu-item[href*="barang-keluar/create"]');
            } else {
                activeSubmenuItem = document.querySelector('.submenu-item[href*="barang-keluar"][href$="index"]');
                if (!activeSubmenuItem) {
                    activeSubmenuItem = document.querySelector('.submenu-item[href*="barang-keluar"]');
                }
            }
            
            if (activeSubmenuItem) {
                activeSubmenuItem.classList.add('active');
            }
            return;
        }
        
        if (currentUrl.includes('barang-masuk')) {
            const barangMasukNavItem = document.querySelector('.nav-item:has([data-target="#collapseBarangMasuk"])');
            if (barangMasukNavItem) {
                barangMasukNavItem.classList.add('active');
                barangMasukNavItem.classList.add('open'); open
                const navLink = barangMasukNavItem.querySelector('.nav-link');
                if (navLink) navLink.classList.add('active');
                
                const submenu = document.querySelector('#collapseBarangMasuk');
                if (submenu) {
                    submenu.classList.add('show');
                }
            }
            
            let activeSubmenuItem = null;
            if (currentUrl.includes('barang-masuk/create')) {
                activeSubmenuItem = document.querySelector('.submenu-item[href*="barang-masuk/create"]');
            } else {
                activeSubmenuItem = document.querySelector('.submenu-item[href*="barang-masuk"][href$="index"]');
                if (!activeSubmenuItem) {
                    activeSubmenuItem = document.querySelector('.submenu-item[href*="barang-masuk"]');
                }
            }
            
            if (activeSubmenuItem) {
                activeSubmenuItem.classList.add('active');
            }
            return;
        }
        
        const navLinks = document.querySelectorAll('.sidebar .nav-link:not(.dropdown-toggle)');
        navLinks.forEach(link => {
            const href = link.getAttribute('href');
            if (href && href !== '#' && (currentUrl === href || currentUrl === href + '/' || currentUrl.includes(href))) {
                link.parentElement.classList.add('active');
                link.classList.add('active');
            }
        });
    }
    
    setActiveNavItem();
    
    function toggleSidebar(e) {
        if (e) e.preventDefault();
        body.classList.toggle('sidebar-toggled');
        
        if (body.classList.contains('sidebar-toggled')) {
            localStorage.setItem('sidebarState', 'collapsed');
        } else {
            localStorage.setItem('sidebarState', 'expanded');
        }
        
        if (sidebarToggle) {
            const icon = sidebarToggle.querySelector('i');
            if (body.classList.contains('sidebar-toggled')) {
                icon.classList.remove('bi-chevron-left');
                icon.classList.add('bi-chevron-right');
            } else {
                icon.classList.remove('bi-chevron-right');
                icon.classList.add('bi-chevron-left');
            }
        }
        
        updateFloatingDropdowns();
    }
    
    function closeAllDropdowns() {
        const currentUrl = window.location.href;
        const navItems = document.querySelectorAll('.sidebar .nav-item');
        
        navItems.forEach(item => {
            const targetId = item.querySelector('.dropdown-toggle')?.getAttribute('data-target');
            
            const shouldStayOpen = 
                (targetId === '#collapseBarangKeluar' && currentUrl.includes('barang-keluar')) ||
                (targetId === '#collapseBarangMasuk' && currentUrl.includes('barang-masuk'));
            
            if (!shouldStayOpen) {
                item.classList.remove('open');
                const submenu = item.querySelector('.sidebar-submenu');
                if (submenu) {
                    submenu.classList.remove('show');
                }
            }
        });
    }
    
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', toggleSidebar);
    }
    
    if (sidebarToggleTop) {
        sidebarToggleTop.addEventListener('click', toggleSidebar);
    }
    
    const dropdownToggles = document.querySelectorAll('.sidebar .dropdown-toggle');
    
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation(); 
            
            if (body.classList.contains('sidebar-toggled') && window.innerWidth >= 768) {
                return;
            }
            
            const navItem = this.closest('.nav-item');
            const targetId = this.getAttribute('data-target');
            const submenu = document.querySelector(targetId);
            
            if (navItem && submenu) {
                document.querySelectorAll('.sidebar .nav-item').forEach(item => {
                    if (item !== navItem) {
                        item.classList.remove('open');
                        const otherSubmenu = item.querySelector('.sidebar-submenu');
                        if (otherSubmenu) {
                            otherSubmenu.classList.remove('show');
                        }
                    }
                });
                
                const wasOpen = navItem.classList.contains('open');
                navItem.classList.toggle('open');
                submenu.classList.toggle('show');
                
                const icon = this.querySelector('.dropdown-toggle::after');
                if (icon) {
                    if (wasOpen) {
                        icon.textContent = "\f282";
                    } else {
                        icon.textContent = "\f286"; 
                    }
                }
            }
        });
    });
    
    const dropdownContainer = document.createElement('div');
    dropdownContainer.id = 'sidebar-dropdown-container';
    document.body.appendChild(dropdownContainer);
    
    const navItems = document.querySelectorAll('.sidebar .nav-item');

    navItems.forEach(item => {
        const dropdownToggle = item.querySelector('.dropdown-toggle');
        const submenu = item.querySelector('.sidebar-submenu');
        
        if (dropdownToggle && submenu) {
            const floatingDropdown = document.createElement('div');
            floatingDropdown.className = 'sidebar-floating-dropdown';
            floatingDropdown.id = submenu.id + '-floating';
            floatingDropdown.style.position = 'fixed'; 
            floatingDropdown.style.zIndex = '1100'; 
            
            const submenuInner = submenu.querySelector('.submenu-inner');
            if (submenuInner) {
                floatingDropdown.innerHTML = submenuInner.outerHTML;
                
                const arrow = document.createElement('div');
                arrow.className = 'floating-dropdown-arrow';
                floatingDropdown.appendChild(arrow);
                
                const submenuItems = floatingDropdown.querySelectorAll('.submenu-item');
                submenuItems.forEach(subItem => {
                    subItem.addEventListener('click', () => {
                        const href = subItem.getAttribute('href');
                        if (href && href !== '#') {
                            window.location.href = href;
                        }
                    });
                });
                
                document.body.appendChild(floatingDropdown);
                
                item.addEventListener('mouseenter', function() {
                    if (body.classList.contains('sidebar-toggled') && window.innerWidth >= 768) {
                        document.querySelectorAll('.sidebar-floating-dropdown').forEach(dropdown => {
                            if (dropdown !== floatingDropdown) {
                                dropdown.style.display = 'none';
                            }
                        });
                        
                        const rect = item.getBoundingClientRect();
                        floatingDropdown.style.top = rect.top + 'px';
                        floatingDropdown.style.left = (rect.right + 5) + 'px';
                        
                        floatingDropdown.style.display = 'block';
                        
                        arrow.style.top = '1rem';
                        arrow.style.left = '-0.5rem';
                    }
                });
                
                const handleMouseLeave = function() {
                    if (body.classList.contains('sidebar-toggled') && window.innerWidth >= 768) {
                        setTimeout(() => {
                            if (!item.matches(':hover') && !floatingDropdown.matches(':hover')) {
                                floatingDropdown.style.display = 'none';
                            }
                        }, 100); 
                    }
                };
                
                item.addEventListener('mouseleave', handleMouseLeave);
                floatingDropdown.addEventListener('mouseleave', handleMouseLeave);
            }
        }
    });
    
    function updateFloatingDropdowns() {
        if (body.classList.contains('sidebar-toggled') && window.innerWidth >= 768) {
            const visibleDropdown = document.querySelector('.sidebar-floating-dropdown[style*="display: block"]');
            if (visibleDropdown) {
                const dropdownId = visibleDropdown.id;
                const submenuId = dropdownId.replace('-floating', '');
                const navItem = document.querySelector(`.nav-item:has([data-target="#${submenuId}"])`);
                
                if (navItem) {
                    const rect = navItem.getBoundingClientRect();
                    visibleDropdown.style.top = rect.top + 'px';
                    visibleDropdown.style.left = (rect.right + 5) + 'px';
                }
            }
        } 
        else if (window.innerWidth < 768) {
            document.querySelectorAll('.sidebar-floating-dropdown').forEach(dropdown => {
                dropdown.style.display = 'none';
            });
        }
    }
    
    document.addEventListener('click', function(e) {
        const contentArea = document.querySelector('#content-wrapper');
        const currentUrl = window.location.href;
        
        if (!sidebar.contains(e.target) && 
            !e.target.closest('.dropdown-toggle') && 
            !dropdownContainer.contains(e.target)) {
            
            document.querySelectorAll('.sidebar-floating-dropdown').forEach(dropdown => {
                dropdown.style.display = 'none';
            });
            
            const isBarangKeluarPage = currentUrl.includes('barang-keluar');
            const isBarangMasukPage = currentUrl.includes('barang-masuk');
            
            if (contentArea && contentArea.contains(e.target) && 
                (isBarangKeluarPage || isBarangMasukPage)) {
                return;
            }
            
            closeAllDropdowns();
        }
    });
    
    window.addEventListener('resize', updateFloatingDropdowns);
    
    setActiveNavItem();
    
    document.addEventListener('turbolinks:load', setActiveNavItem); 
    document.addEventListener('page:load', setActiveNavItem);     
    
    window.addEventListener('beforeunload', function() {
        const currentUrl = window.location.href;
        
        if (currentUrl.includes('barang-keluar')) {
            localStorage.setItem('activeDropdown', 'collapseBarangKeluar');
        } else if (currentUrl.includes('barang-masuk')) {
            localStorage.setItem('activeDropdown', 'collapseBarangMasuk');
        } else {
            localStorage.removeItem('activeDropdown');
        }
    });
    
    const storedActiveDropdown = localStorage.getItem('activeDropdown');
    if (storedActiveDropdown) {
        const targetElement = document.getElementById(storedActiveDropdown);
        const parentNavItem = document.querySelector(`.nav-item:has([data-target="#${storedActiveDropdown}"])`);
        
        if (targetElement && parentNavItem) {
            targetElement.classList.add('show');
            parentNavItem.classList.add('open');
        }
    }
});