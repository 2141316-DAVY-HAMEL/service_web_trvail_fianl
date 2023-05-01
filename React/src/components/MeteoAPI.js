import React, { useState, useEffect } from 'react';
import axios from 'axios';

const MeteoAPI = () => {
  const [weatherData, setWeatherData] = useState(null);

  useEffect(() => {
    const apiKey = '9ea9f9ba2e53322aa3e77b292a7921a2';
    const apiUrl = `https://api.openweathermap.org/data/2.5/weather?q=Montreal&appid=${apiKey}`;

    axios
      .get(apiUrl)
      .then((response) => {
        setWeatherData(response.data);
      })
      .catch((error) => {
        console.error('Error fetching weather data:', error);
      });
  }, []);

  if (!weatherData) {
    return <div>Chargement de la météo...</div>;
  }

  return (
    <div>
      <h3>Météo a {weatherData.name}</h3>
      <p>Température: {(weatherData.main.temp - 273.15).toFixed(1)}°C</p>
      <p>Humidité: {weatherData.main.humidity}%</p>
      <p>Condition: {weatherData.weather[0].description}</p>
    </div>
  );
};

export default MeteoAPI;
