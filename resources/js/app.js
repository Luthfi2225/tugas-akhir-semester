document.addEventListener('livewire:navigated', () => {
    const sidebar = document.getElementById('sidebar');
    const sidebarContainer = document.getElementById('sidebarContainer');
    const toggleSidebar = document.getElementById('toggleSidebar');
    const sidebarTitle = document.getElementById('sidebarTitle');
    const sidebarCategory = document.querySelectorAll('.sidebarCategory');
    const sidebarText = document.querySelectorAll('.sidebarText');
    const sidebarFooter = document.getElementById('sidebarFooter');
    const profileButton = document.getElementById('profileButton');
    const settingButton = document.getElementById('settingButton');

    const updateSidebarUI = (shouldClose) => {
        if (shouldClose) {
            sidebar.classList.replace('w-64', 'w-16');
            sidebarContainer.classList.replace('h-210', 'h-188');
            sidebarTitle.classList.add('opacity-0');
            sidebarCategory.forEach(el => el.classList.add('opacity-0'));
            sidebarText.forEach(el => el.classList.add('opacity-0'));
            setTimeout(() => {
                sidebarTitle.classList.add('hidden');
                sidebarCategory.forEach(el => el.classList.add('hidden'));
                sidebarText.forEach(el => el.classList.add('hidden'));
            }, 300);
            sidebarFooter.classList.replace('w-59.5', 'w-12');
            sidebarFooter.classList.replace('bottom-10', 'bottom-35');
            profileButton.classList.replace('top-2', 'top-14.5');
            profileButton.classList.replace('left-24.5', 'left-0.75');
            settingButton.classList.replace('top-2', 'top-27');
            settingButton.classList.replace('left-48.25', 'left-0.75');
        } else {
            sidebar.classList.replace('w-16', 'w-64');
            setTimeout(() => {
                sidebarContainer.classList.replace('h-188', 'h-210');
            }, 200);
            sidebarTitle.classList.remove('opacity-0', 'hidden');
            sidebarCategory.forEach(el => el.classList.remove('opacity-0', 'hidden'));
            setTimeout(() => {
                sidebarText.forEach(el => el.classList.remove('opacity-0', 'hidden'));
            }, 50);
            sidebarFooter.classList.replace('w-12', 'w-59.5');
            sidebarFooter.classList.replace('bottom-35', 'bottom-10');
            profileButton.classList.replace('top-14.5', 'top-2');
            profileButton.classList.replace('left-0.75', 'left-24.5');
            settingButton.classList.replace('top-27', 'top-2');
            settingButton.classList.replace('left-0.75', 'left-48.25');
        }
    };

    if (sidebar) {
        const isClosed = localStorage.getItem('sidebarClosed') === 'true';
        if (isClosed) {
            updateSidebarUI(true);
        }
    }

    if (toggleSidebar && sidebar) {
        toggleSidebar.addEventListener('click', () => {
            const willClose = sidebar.classList.contains('w-64');
            updateSidebarUI(willClose);
            localStorage.setItem('sidebarClosed', willClose);
        });
    }
});
