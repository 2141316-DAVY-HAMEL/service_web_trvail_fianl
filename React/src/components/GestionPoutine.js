// GestionPoutine.js
import React, { useState } from 'react';
import ListePoutine from './ListePoutine';
import FormGestionPoutine from './FormGestionPoutine';

function GestionPoutine() {
  const [updateList, setUpdateList] = useState(false);
  const [poutineSelected, setPoutineSelected] = useState(null);

  const handlePoutineChanged = () => {
    setUpdateList(!updateList);
  };

  const handleSelect = (poutine) => {
    setPoutineSelected(poutine);
  };

  return (
    <div className="App">
      <header className="App-header">
        <h1>Les poutines</h1>
        <FormGestionPoutine onPoutineChanged={handlePoutineChanged} poutineSelected={poutineSelected} />
        <ListePoutine updateList={updateList} onSelect={handleSelect} />
      </header>
    </div>
  );
}

export default GestionPoutine;