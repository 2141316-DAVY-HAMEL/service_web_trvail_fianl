import React, { useState } from 'react';
import axios from 'axios';

const ApiCleGen = () => {
  const [code, setCode] = useState('');
  const [password, setPassword] = useState('');
  const [apiKey, setApiKey] = useState('');

  const handleUsernameChange = (event) => {
    setCode(event.target.value);
  };

  const handlePasswordChange = (event) => {
    setPassword(event.target.value);
  };

  const handleGenerateApiKeyClick = () => {
    const base64Credentials = btoa(`${code}:${password}`);
    axios.get('http://127.0.0.1/sevice_web/projetfinal/cle?nouvelle=true', {
      
    headers: {
      Authorization : 'Bearer ' + base64Credentials
    }}
    ).then((response) => {
      setApiKey(response.data.api_key);
    }).catch((error) => {
      console.error('Erreur lors de la génération de la clé API:', error);
      console.error(base64Credentials);
      alert('Erreur lors de la génération de la clé API. Veuillez réessayer.');
    });
  };

  return (
    <div>
      <input type="text" placeholder="Utilisateur" value={code} onChange={handleUsernameChange} />
      <input type="password" placeholder="Mot de passe" value={password} onChange={handlePasswordChange} />
      <button onClick={handleGenerateApiKeyClick}>Générer clé API</button>
      {apiKey && <div>Clé API : {apiKey}</div>}
    </div>
  );
};

export default ApiCleGen;
