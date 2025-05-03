import { useEffect, useState } from "react";
import { Moon, Sun } from "lucide-react";

const DarkMode = () => {
  const getInitialTheme = () => {
    if (typeof window !== "undefined") {
      const storedTheme = localStorage.getItem("theme");
      if (storedTheme) {
        return storedTheme === "dark";
      }
      return window.matchMedia("(prefers-color-scheme: dark)").matches;
    }
    return false;
  };

  const [darkMode, setDarkMode] = useState(getInitialTheme());

  useEffect(() => {
    if (darkMode) {
      document.documentElement.classList.add("dark");
      localStorage.setItem("theme", "dark");
    } else {
      document.documentElement.classList.remove("dark");
      localStorage.setItem("theme", "light");
    }
    console.log("HTML class list:", document.documentElement.classList); // Debugging
  }, [darkMode]);

  return (
    <div className="flex justify-center items-center">
      <button
        onClick={() => setDarkMode(!darkMode)}
        className="p-2 rounded-full cursor-pointer transition duration-300 sm:p-1 sm:text-sm"
      >
        {darkMode ? (
          <Moon className="text-white sm:w-6 sm:h-6 md:w-8 md:h-8"  />
        ) : (
          <Sun className="text-yellow-600 sm:w-6 sm:h-6 md:w-8 md:h-8"  />
        )}
      </button>
    </div>
  );
};

export default DarkMode;
