import React, { useState, useEffect } from "react";
import api from "../utils/Api";
import Titre from "./Titre";
import Tableau from "./Tableau";
import styles from "./ListePoutine.css";

const ListePoutine = ({ onSelect, updateList }) => {
  const [poutine, setPoutines] = useState([]);

  useEffect(() => {
    api.get("/poutine").then((response) => {
      const sortedPoutine = response.data.poutine.sort((a, b) => a.id - b.id);
      setPoutines(sortedPoutine);
    });
  }, [updateList]);

  const handleSelect = (poutine) => {
    onSelect(poutine);
  };

  return (
    <div className="ListePoutine">
      <Titre texte="Liste des poutines" />
      <Tableau poutines={poutine} onSelect={handleSelect} updateList={updateList} />
    </div>
  );
};

export default ListePoutine;