import React from "react";
import i18n from "i18next";
import { initReactI18next, useTranslation } from "react-i18next";
import En from "../assets/images/flag/en.png";
import Kh from "../assets/images/flag/kh.png";

// Initialize translations
const resources = {
  en: {
    translation: {
      //header and footer
      school_title: " Monisakor Primary School",
      descr:
        "Welcome to Monisakor Primary School! Providing quality education for all students.",
      location:
        "Trapeang Trach Village, Svay Tayan Commune, Kampong Rou District, Svay Rieng Province",
      link: "Link Our Social Media ",
      copy_right:
        "© 2023-2025 All Rights Reserved by Monisakor Primary School",
      joinus: "Join Us",
      home: "Home",
      news: "News",
      about_us: "About Us",
      extras: "Extras",
      contact_us: "Contact Us",
      //end footer and header
      //index
      vision: "Monisakor Primary School's Vision",
      mission: "Monisakor Primary School's Mission",
      moreevents: "More Events",
      //end index
      // news
      news_intro: "Welcome To News Page",
      news_intro_desc: "In this page,you can find information and see the latest news",
      news_title: "News",
      search_news: "Search by name description and date...",
      prev: "Prev",
      next: "Next",
      //end news
      //about us
      about_intro: " Welcome to Monisakor Primary School",
      about_intor_desc: "Providing quality education for all students.",
      history: "History",
      sms: "Message from Moni Primary School",
      principal: "Sen Sosokly",
      tel: "Phone Number:",
      explore: "Explore to the Management of Administration",
      rule_title: "Rules and Regulations",
      //end about us
      //extra
      extra_title: "Extra",
      gallery: "School Gallery",
      gallery_desc: "Images of Monisakor Primary School",
      class_routine: "Class Routine",
      class_routine_desc: "Class Routine of School",
      calender: " Calendar",
      calender_desc: "Holidays, Events, Days",
      staffs: "Staffs",
      staffs_desc: "Staffs of School",
      social_links: "Social Media Links",
      social_links_desc: "Social Media Links of School",
      moeys: "MOEYS",
      moeys_desc: "Visit the Ministry of Education, Youth, and Sports",
      //end extra
      //contact us
      call: "Call",
      message: "Message",
      address: "Address",
      feedback: "Feedback",
      feedback_desc:
        "Your valuable feedback for our school is highly appreciated and awaited here.",
      name: "Name",
      phone: "phone",
      send: "Send",
      feedback_text:
        "Your feedback will be sent to the school administration.",
      thank_feedback: "Thank you for your feedback.",
      success: " Your Message sentsuccessfuly!",
      phone_invalid: "Please enter a valid phone number (start with 0 and 8-10 digits)",
      //end contact us
      //Join us
      joinus: "Join Us",
      admission: "Addmission Form",
      admission_desc:
        "Please ensure to fill out your form with honesty. Review all details such as personal information and your studies to avoid mistakes. Your honest submission will help to make your application stand out. If you have any questions feel free to contact the admission office for assistance.",
      btnjoin: "Register",
      btnscroll: "Scroll down to register students",
      //end join us
      //gallery
      gallery: "Gallery Allbum",
      open: "Open",
      veiw: "View",
      //stafff
      committee: " Management Committee",
      staff: "Staffs",
      //news detail
      recent_news: "Recent News",
      trending_news: "Trending News",
    },
  },
  kh: {
    translation: {
      // header and footer
      school_title: "សាលាបឋមសិក្សាមុន្នីសាគរ",
      descr:
        "ស្វាគមន៍មកកាន់សាលាបឋមសិក្សាមុន្នីសាគរ!ផ្ដល់ការអប់រំដែលមានគុណភាពសម្រាប់មនុស្សគ្រប់វ័យ។",
      location:
        "ភូមិត្រពាងត្រាច,ឃំុស្វាយតាយាន​, ស្រុកកំពុងរោទ៍, ខេត្តស្វាយរៀង",
      link: "តំណភ្ជាប់ប្រព័ន្ធផ្សព្វផ្សាយសង្គម",
      copy_right:
        "រក្សាសិទ្ធិ © 2023-2025 រក្សាសិទ្ធិគ្រប់យ៉ាងដោយ សាលាបឋមសិក្សាមុន្នីសាគរ",
      joinus: "ចុះឈ្មោះ",
      home: "ទំព័រដើម",
      news: "ព័ត៌មាន",
      about_us: "អំពីយើង",
      extras: "បន្ថែម",
      contact_us: "ទំនាក់ទំនង",
      //end footer and header
      //index
      vision: "ចក្ខុវិស័យសាលាបឋមសិក្សាមុន្នីសាគរ",
      mission: "បេសកកម្មសាលាបឋមសិក្សាមុន្នីសាគរ",
      moreevents: "ព័ត៌មានបន្ថែម",
      //end index
      // news
      news_intro: "ស្វាគមន៍មកកាន់ទំព័រព័ត៌មាន!",
      news_intro_desc: "នៅក្នុងទំព័រនេះអ្នកអាចស្វែងរកព័ត៌មាន និងមើលព័ត៌មានថ្មីៗ ",
      news_title: "ព័ត៌មាន",
      search_news: "ស្វែងរកតាមឈ្មោះ ការពិពណ៌នា និងកាលបរិច្ឆេទ...",
      prev: "មុន",
      next: "បន្ទាប់",
      //end news
      //about us
      about_intro: "ស្វាគមន៍មកកាន់សាលាបឋមសិក្សាមុន្នីសាគរ",
      about_intor_desc: "ផ្ដល់ការអប់រំដែលមានគុណភាពសម្រាប់មនុស្សគ្រប់វ័យ។",
      history: "ប្រវត្តិ",
      sms: "សារពីសាលាបឋមសិក្សាមុន្នីសាគរ",
      principal: "សែន សូសុខលី",
      tel: "លេខទូរស័ព្ទ:",
      explore: "រុករកទៅគណៈកម្មាធិការគ្រប់គ្រង",
      rule_title: "ច្បាប់ និងបទប្បញ្ញត្តិ",
      //end about us
      //extra
      extra_title: "បន្ថែម",
      gallery: "វិចិត្រសាលា",
      gallery_desc: "រូបភាពសាលាបឋមសិក្សាមុន្នីសាគរ",
      class_routine: " ទម្លាប់ថ្នាក់",
      class_routine_desc: "ទម្លាប់ថ្នាក់របស់សាលា",
      calender: "ប្រតិទិន",
      calender_desc: "ថ្ងៃឈប់សម្រាក, ព្រឹត្តិការណ៍, ថ្ងៃ",
      staffs: "បុគ្គលិក",
      staffs_desc: "បុគ្គលិករបស់សាលា",
      social_links: "តំណភ្ជាប់ប្រព័ន្ធផ្សព្វផ្សាយសង្គម",
      social_links_desc: "តំណភ្ជាប់ប្រព័ន្ធផ្សព្វផ្សាយសង្គមរបស់សាលា",
      moeys: "ក្រសួងអប់រំយុវជននិងកីឡា",
      moeys_desc: "ទស្សនាក្រសួងអប់រំយុវជននិងកីឡា",
      //end extra
      //contact us
      call: "ហៅ",
      message: "ផ្ញើសារ",
      address: "អាសយដ្ឋាន",
      feedback: "មតិយោបល់",
      feedback_desc:
        "មតិយោបល់ដែលមិនអាចកាត់ថ្លៃបានរបស់អ្នកសម្រាប់សាលារបស់យើងគឺរង់ចាំយ៉ាងខ្លាំងនិងកោតសរសើរនៅទីនេះ។",
      name: "ឈ្មោះ",
      phone: "លេខទូរស័ព្ទ",
      send: "ផ្ញើ",
      feedback_text:
        "ការបញ្ចូលរបស់អ្នកនឹងត្រូវបានបញ្ជូនបន្តទៅរដ្ឋបាលសាលារៀន។",
      thank_feedback: "សូមអរគុណចំពោះការឆ្លើយតបរបស់អ្នក។",
      success: "សាររបស់អ្នកបានផ្ញើដោយជោគជ័យ!",
      phone_invalid: "សូមបញ្ចូលលេខទូរស័ព្ទត្រឹមត្រូវ (ចាប់ផ្តើមដោយលេខ 0 មានចន្លោះ 8-10 ខ្ទង់)",

      //end contact us
      //Join us
      joinus: "ចុះឈ្មោះ",
      admission: "ទម្រង់ចុះឈ្មោះចូលរៀន",
      admission_desc:
        "ត្រូវប្រាកដថាបំពេញទម្រង់នៃការទទួលបានរបស់អ្នកដោយយកចិត្តទុកដាក់។ ពិនិត្យព័ត៌មានលម្អិតទាំងអស់ដូចជាព័ត៌មានផ្ទាល់ខ្លួននិងការសិក្សារបស់អ្នកដើម្បីចៀសវាងកំហុស។ ការប្រុងប្រយ័ត្នរបស់អ្នកនឹងជួយធ្វើឱ្យដំណើរការដាក់ពាក្យសុំរបស់អ្នករលូន។ ប្រសិនបើអ្នកមានសំណួរសូមមានអារម្មណ៍ដោយឥតគិតថ្លៃក្នុងការស្នើសុំការិយាល័យចូលរៀនសម្រាប់ជំនួយ។",
      btnjoin: "ចុះឈ្មោះ",
      btnscroll: "រមូរដើម្បីចុះឈ្មោះសិស្ស",
      //end join us
      //gallery
      gallery: "អាល់ប៊ុមវិចិត្រសាល",
      open: "បើក",
      veiw: "មើល",
      //stafff
      committee: " គណៈកម្មាធិការគ្រប់គ្រង",
      staff: "បុគ្គលិក",
      //news detail
      recent_news: "ព័ត៌មានថ្មីៗ",
      trending_news: "ព័ត៌មានល្បីៗ",
    },
  },
};

i18n
  .use(initReactI18next)
  .init({
    resources,
    lng: "kh", // <- Set default language to Khmer
    fallbackLng: "en",
    interpolation: { escapeValue: false },
  });

const LanguageSwitcher = () => {
  const { i18n } = useTranslation();

  const toggleLanguage = () => {
    i18n.changeLanguage(i18n.language === "en" ? "kh" : "en");
  };

  return (
    <button
      onClick={toggleLanguage}
      className="hover:scale-105 transition duration-300 p-2"
    >
      <img
        src={i18n.language === "en" ? Kh : En}
        alt="Switch Language"
        className="w-8 h-4 md:w-10 md:h-6 object-cover"
      />
    </button>
  );
};

  
export default LanguageSwitcher;
