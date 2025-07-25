function data() {
    // Função para obter o tema do localStorage ou das preferências do sistema
    function getThemeFromLocalStorage() {
      if (window.localStorage.getItem('dark')) {
        return JSON.parse(window.localStorage.getItem('dark'));
      }
      return (
        !!window.matchMedia &&
        window.matchMedia('(prefers-color-scheme: dark)').matches
      );
    }

    // Função para salvar o tema no localStorage
    function setThemeToLocalStorage(value) {
      window.localStorage.setItem('dark', JSON.stringify(value));
    }

    // Retorna o estado inicial e métodos disponíveis
    return {
      // Gerenciamento do tema
      dark: getThemeFromLocalStorage(),
      toggleTheme() {
        this.dark = !this.dark;
        setThemeToLocalStorage(this.dark);
        document.documentElement.setAttribute(
          'data-theme',
          this.dark ? 'dark' : 'light'
        );
      },

      // Gerenciamento do menu lateral
      isSideMenuOpen: false,
      toggleSideMenu() {
        this.isSideMenuOpen = !this.isSideMenuOpen;
      },
      closeSideMenu() {
        this.isSideMenuOpen = false;
      },

      // Gerenciamento do menu de notificações
      isNotificationsMenuOpen: false,
      toggleNotificationsMenu() {
        this.isNotificationsMenuOpen = !this.isNotificationsMenuOpen;
      },
      closeNotificationsMenu() {
        this.isNotificationsMenuOpen = false;
      },

      // Gerenciamento do menu de perfil
      isProfileMenuOpen: false,
      toggleProfileMenu() {
        this.isProfileMenuOpen = !this.isProfileMenuOpen;
      },
      closeProfileMenu() {
        this.isProfileMenuOpen = false;
      },

      // Gerenciamento do menu de páginas
      isPagesMenuOpen: false,
      togglePagesMenu() {
        this.isPagesMenuOpen = !this.isPagesMenuOpen;
      },

      // Gerenciamento do modal
      isModalOpen: false,
      trapCleanup: null,
      openModal() {
        this.isModalOpen = true;
        this.trapCleanup = focusTrap(document.querySelector('#modal'));
      },
      closeModal() {
        this.isModalOpen = false;
        if (this.trapCleanup) this.trapCleanup();
      },

      // Gerenciamento do menu Configurações
      isSettingsMenuOpen: false,
      toggleSettingsMenu() {
        this.isSettingsMenuOpen = !this.isSettingsMenuOpen;
      },
      closeSettingsMenu() {
        this.isSettingsMenuOpen = false;
      },
    };
  }
