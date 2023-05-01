import './App.css';
import React from 'react';
import GestionPoutine from './components/GestionPoutine';
import MeteoAPI from './components/MeteoAPI';
import ApiCleGen from './components/ApiCleGen';

function App() {
  return (
    <div className="App">
      <ApiCleGen />
      <MeteoAPI />
      <GestionPoutine />
    </div>
  );
}

export default App;