import { FaBook, FaPen, FaPencilAlt, FaGraduationCap, FaChalkboardTeacher, FaBookOpen } from 'react-icons/fa';

const BackgroundIcons = () => {
  return (
    <div className="absolute inset-0 overflow-hidden left-5">
      {Array.from({ length: 200 }).map((_, index) => {
        const randomX = Math.random() * 95; // random left %
        const randomY = Math.random() * 100; // random top %
        const randomSize = Math.floor(Math.random() * 20) + 16; // random size between 12px-28px
        const icons = [
          <FaBook />,
          <FaPen />,
          <FaPencilAlt />,
          <FaGraduationCap />,
          <FaChalkboardTeacher />,
          <FaBookOpen />
        ]; // Education-related icons
        const randomIcon = icons[Math.floor(Math.random() * icons.length)];

        // Random color for each icon (light pastel colors for a softer effect)
        const colors = ["#FFB6C1", "#B0E0E6", "#98FB98", "#FFD700", "#D3D3D3"];
        const randomColor = colors[Math.floor(Math.random() * colors.length)];

        return (
          <div
            key={index}
            className="absolute"
            style={{
              left: `${randomX}%`,
              top: `${randomY}%`,
              fontSize: `${randomSize}px`,
              transform: `rotate(${Math.random() * 360}deg)`,
              opacity: 0.4, // Soft opacity
              color: randomColor, // Random color for each icon
              transition: 'transform 0.5s ease-in-out', // Smooth rotation transition
              cursor: 'pointer', // Add a pointer cursor to indicate interactivity
            }}
            onMouseEnter={(e) => {
              e.target.style.transform = `scale(1.2) rotate(${Math.random() * 360}deg)`; // Slight scale and rotation on hover
            }}
            onMouseLeave={(e) => {
              e.target.style.transform = `rotate(${Math.random() * 360}deg)`; // Reset rotation on mouse leave
            }}
          >
            {randomIcon}
          </div>
        );
      })}
    </div>
  );
};

export default BackgroundIcons;
