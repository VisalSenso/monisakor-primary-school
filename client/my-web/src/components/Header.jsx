// Header.jsx
import React, { useState, useEffect, useCallback } from "react";
import AOS from "aos";
import "aos/dist/aos.css";
import { useTranslation } from "react-i18next";
import DarkMode from "../components/DarkMode.jsx";
import img9 from "../assets/images/schoolImages/9.jpg";
import Logo from "../assets/images/schoolImages/logo.png";
import { Link, useLocation } from "react-router-dom";
import LanguageSwitcher from "./LanguageSwitcher.jsx";
import JoinModal from "../pages/JoinModal.jsx";
import { FaBars, FaTimes,FaPen } from "react-icons/fa";

const Header = () => {
  const [isMenuOpen, setIsMenuOpen] = useState(false);
  const [isDarkMode, setIsDarkMode] = useState(
    localStorage.getItem("theme") === "dark"
  );
  const [language, setLanguage] = useState(
    localStorage.getItem("language") || "kh"
  );
  const [isVisible, setIsVisible] = useState(true);
  const [scrolled, setScrolled] = useState(false);  // Add scrolled state
  const { t } = useTranslation();
  const location = useLocation();
  const [isJoinModalOpen, setIsJoinModalOpen] = useState(false);


  useEffect(() => {
    if (typeof window !== "undefined") {
      AOS.init({ duration: 1000 });
    }
  }, []);

  const toggleMenu = useCallback(() => {
    setIsMenuOpen((prev) => !prev);
  }, []);

  const toggleDarkMode = useCallback(() => {
    setIsDarkMode((prevMode) => {
      const newMode = !prevMode;
      localStorage.setItem("theme", newMode ? "dark" : "light");
      return newMode;
    });
  }, []);

  const switchLanguage = useCallback((newLang) => {
    setLanguage(newLang);
    localStorage.setItem("language", newLang);
  }, []);

  useEffect(() => {
    if (isDarkMode) {
      document.body.classList.add("dark");
      document.body.classList.remove("light");
    } else {
      document.body.classList.add("light");
      document.body.classList.remove("dark");
    }
  }, [isDarkMode]);

  useEffect(() => {
    let lastScrollTop = 0;

    const handleScroll = () => {
      const currentScroll = window.pageYOffset;

      // show/hide navbar based on scroll direction
      if (currentScroll > lastScrollTop) {
        setIsVisible(false); // scrolling down
      } else {
        setIsVisible(true); // scrolling up
      }

      // background trigger
      setScrolled(currentScroll > 50);  // Set scrolled state

      lastScrollTop = currentScroll <= 0 ? 0 : currentScroll;
    };

    window.addEventListener("scroll", handleScroll);
    return () => window.removeEventListener("scroll", handleScroll);
  }, []);

  return (
    <div
      className="relative w-full h-screen bg-cover bg-center transition-colors duration-300"
      style={{ backgroundImage: `url(${img9})` }}
    >
      <div className="absolute inset-0 bg-gradient-to-t from-black via-black/10 to-transparent"></div>
      <div className="absolute inset-0 bg-gradient-to-b from-black via-black/50 to-transparent"></div>
      {/* Navbar */}
      <nav
        className={`fixed top-0 left-0 w-full flex justify-between items-center p-2 z-[999] transition-all duration-300 ${isVisible ? "translate-y-0" : "-translate-y-full"} ${scrolled ? "bg-black/60 backdrop-blur-md" : "bg-transparent"}`}
      >
        <Link to="/" className="flex items-center text-gray-900">
          <img
            style={{ cursor: "pointer" }}
            className="w-25 h-25 bg-black-500 rounded-full"
            src={Logo}
            alt="logo"
          />
        </Link>

        {/* Navbar Links */}
        <ul className="hidden md:flex space-x-4 text-white z-90 ">
          {[
            { to: "/", path: "/", label: t("home") },
            { to: "/news#news", path: "/news", label: t("news") },
            { to: "/about#about", path: "/about", label: t("about_us") },
            { to: "/extras#extras", path: "/extras", label: t("extras") },
            { to: "/contact#contact", path: "/contact", label: t("contact_us") },
            // { to: "/test", path: "/test", label: t("test") },
          ].map(({ to, path, label }) => (
            <Link
              key={to}
              to={to}
              className={`text-center text-sm sm:text-xs md:text-lg lg:text-lg font-bold lang-text px-4 py-2 rounded-full transition duration-300 ${location.pathname === path ? "text-primary" : "hover:text-primary dark:hover:text-white"
                }`}
            >
              {label}
            </Link>
          ))}


        </ul>




        {/* Dark Mode and Language Switcher */}
        <div className="flex items-center space-x-4 z-90">
          {/* Mobile Menu Button */}
          <button className="md:hidden text-white text-2xl" onClick={toggleMenu}>
            {isMenuOpen ? <FaTimes /> : <FaBars />}
          </button>
          <DarkMode toggleDarkMode={toggleDarkMode} isDarkMode={isDarkMode} />
          <LanguageSwitcher switchLanguage={switchLanguage} language={language} />

        </div>
      </nav>

      {/* Mobile Menu */}
      <div
        className={`md:hidden fixed top-0 left-0 w-full h-screen bg-black/80 backdrop-blur-sm z-50 transform transition-transform duration-300 ease-in-out ${isMenuOpen ? "translate-y-0" : "-translate-y-full"
          }`}
      >

        <ul className="flex flex-col items-center justify-center h-full space-y-6 text-white text-xl font-semibold">
          {[
            { to: "/", label: t("home") },
            { to: "/news#news", label: t("news") },
            { to: "/about#about", label: t("about_us") },
            { to: "/extras#extras", label: t("extras") },
            { to: "/contact#contact", label: t("contact_us") },
          ].map(({ to, label }) => (
            <Link
              key={to}
              to={to}
              onClick={toggleMenu}
              className="hover:text-primary transition duration-200"
            >
              {label}
            </Link>
          ))}
        </ul>
      </div>


      {/* Hero Section */}
      <div
        data-aos="fade-up"
        className="relative z-10 flex flex-col items-center justify-center h-full text-center text-white px-4"
      >
        <h1 className="text-3xl sm:text-5xl font-bold font-display">{t("about_intro")}</h1>
        <p className="text-xl sm:text-3xl mt-4 max-w-2xl">
          {t("about_intor_desc")}
        </p>
        <button
          onClick={() => setIsJoinModalOpen(true)}
          className="mt-5 inline-flex items-center text-white bg-[#E50914] border-0 py-2 px-6 focus:outline-none hover:scale-105 duration-300 rounded-full text-lg cursor-pointer"
        >
         <span className="mr-2"> {t("joinus")}</span>
         <span className="text-sm"><FaPen /></span>
        </button>


      </div>
      {/* Join Modal */}
      {isJoinModalOpen && (
        <JoinModal
          isOpen={isJoinModalOpen}
          onClose={() => setIsJoinModalOpen(false)}
        />
      )}

    </div>
  );

};

export default Header;
