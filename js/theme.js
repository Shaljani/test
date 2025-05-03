document.addEventListener("DOMContentLoaded", () => {
    const themeLink = document.getElementById("theme-style");
    const themeToggle = document.getElementById("themeToggle");
  
    // Déduction automatique du nom de fichier CSS
    const path = themeLink.getAttribute("href"); // ex: css/styleindex.css
    const filename = path.split("/").pop();      // ex: styleindex.css
    const baseName = filename.replace(".css", "").replace("_dark", ""); // ex: styleindex
  
    const defaultTheme = `css/${baseName}.css`;
    const darkTheme = `css_dark/${baseName}_dark.css`;
  
    function getCookie(name) {
      const match = document.cookie.match(new RegExp("(^| )" + name + "=([^;]+)"));
      return match ? match[2] : null;
    }
  
    function setCookie(name, value, days) {
      const expires = new Date(Date.now() + days * 864e5).toUTCString();
      document.cookie = `${name}=${value}; expires=${expires}; path=/`;
    }
  
    // Appliquer le thème sauvegardé
    const savedTheme = getCookie("theme");
    themeLink.href = savedTheme === "dark" ? darkTheme : defaultTheme;
  
    // Changement via le toggle
    if (themeToggle) {
      themeToggle.addEventListener("change", () => {
        const isDark = themeLink.getAttribute("href") === darkTheme;
        themeLink.href = isDark ? defaultTheme : darkTheme;
        setCookie("theme", isDark ? "light" : "dark", 30);
      });
    }
  });
  
