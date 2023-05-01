import React from 'react';

const LigneTableau = ({ poutine, onSelect }) => {
  const handleClick = () => {
    onSelect(poutine);
  };
  return (
    <tr onClick={handleClick}>
      <td>{poutine.id}</td>
      <td>{poutine.nom}</td>
      <td>
        {poutine.description.split('\n').map((line, index) => (
          <span key={index}>
            {line}
            <br />
          </span>
        ))}
      </td>
    </tr>
  );
};

export default LigneTableau;