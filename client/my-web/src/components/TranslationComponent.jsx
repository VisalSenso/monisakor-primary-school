import React, { useState, useEffect } from 'react';

const TranslationComponent = () => {
  const [translations, setTranslations] = useState([]);
  const [language, setLanguage] = useState('en'); // default to English
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const fetchTranslations = async () => {
      setLoading(true);
      try {
        const response = await fetch(`http://localhost/project/monisakor-primary-school/server/api/translations.php?language=${language}`);

        const data = await response.json();  // Make sure to parse as JSON
        setTranslations(data);
      } catch (error) {
        console.error('Error fetching translations:', error);
      } finally {
        setLoading(false);
      }
    };

    fetchTranslations();
  }, [language]); // Runs whenever the language is updated

  const handleChangeLanguage = (newLanguage) => {
    setLanguage(newLanguage);
  };

  return (
    <div className="mt-20">
      <h2>Translations</h2>
      
      <button onClick={() => handleChangeLanguage('en')}>English</button>
      <button onClick={() => handleChangeLanguage('kh')}>Khmer</button>
      
      {loading ? <p>Loading...</p> : (
        <div>
          {translations.map((item, index) => (
            <div key={index}>
              {item.section_name === 'one' || item.section_name === 'two' ? (
                <p>{item.content}</p>
              ) : null}
            </div>
          ))}
        </div>
      )}
    </div>
  );
};

export default TranslationComponent;
