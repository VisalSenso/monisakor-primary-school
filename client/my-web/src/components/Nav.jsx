import { Link, useLocation } from "react-router-dom";
import { useTranslation } from "react-i18next"; // Import i18next

const Nav = ({ isMenuOpen }) => {
  const location = useLocation();
  const { t } = useTranslation(); // Get the translation function

  return (
    <nav
      id="navMenu"
      className={`max-h-0 transition-all duration-300 ease-in-out md:max-h-none md:block w-full bg-white ${
        isMenuOpen ? "max-h-screen" : ""
      }`}
    >
      <div className="h-20 w-full bg-white dark:bg-backgroun-dark transition shadow-lg dark:text-gray-300 text-gray-600 flex items-center justify-center space-x-10 text-base md:font-bold border-t border-gray-300 dark:border-gray-500 absolute top-full left-0 ">
        {[
          { to: "/", label: t("home") },
          { to: "/news", label: t("news") },
          { to: "/about", label: t("about_us") },
          { to: "/extras", label: t("extras") },
          { to: "/contact", label: t("contact_us") },
          { to: "/test", label: t("Test") },
         
          
        ].map(({ to, label }) => (
          <Link
            key={to}
            to={to}
            className={`text-center text-sm sm:text-xs md:text-lg lg:text-lg font-bold lang-text px-4 py-2 rounded-full transition duration-300 ${
              location.pathname === to
                ? "bg-secondary text-white dark:text-white"
                : "hover:text-gray-900 dark:hover:text-white"
            }`}
          >
            {label}
          </Link>
        ))}
      </div>
    </nav>
  );
};

export default Nav;
