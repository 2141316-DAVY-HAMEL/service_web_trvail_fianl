import React from 'react';
import LigneTableau from './LigneTableau';

const Tableau = ({ poutines, onSelect }) => {
  return (
    <table className="PoutinesTable">
      <thead>
        <tr>
          <th>id</th>
          <th>Nom</th>
          <th>Description</th>
        </tr>
      </thead>
      <tbody>
        {poutines.map((poutine) => (
          <LigneTableau key={poutine.id} poutine={poutine} onSelect={onSelect} />
        ))}
      </tbody>
    </table>
  );
};

export default Tableau;