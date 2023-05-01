import React, { useState, useEffect } from "react";
import api from "../utils/Api";
import styles from "./FormGestionPoutine.css";

const FormGestionPoutine = ({ onPoutineChanged, poutineSelected }) => {
    const [poutine, setPoutines] = useState([]);
    const [nom, setNom] = useState("");
    const [description, setDescription] = useState("");
    const [id, setId] = useState("");

    useEffect(() => {
        api.get("/poutine").then((response) => {
            setPoutines(response.data.poutine);
        });
    }, []);

    useEffect(() => {
        if (poutineSelected) {
            setNom(poutineSelected.nom);
            setDescription(poutineSelected.description);
            setId(poutineSelected.id);
        }
    }, [poutineSelected]);

    const handleNomChange = (event) => {
        setNom(event.target.value);
    };

    const handleDescriptionChange = (event) => {
        setDescription(event.target.value);
    };

    const handleNewClick = () => {
        setNom("");
        setDescription("");
        setId("");
    };

    const handleSaveClick = () => {
        if (nom === "") {
            alert("Veuillez entrer un nom pour la poutine.");
            return;
        }

        const newPoutine = { nom, description };

        if (id === "") {
            api.post("/poutine", newPoutine).then((response) => {
                setPoutines([...poutine, response.data]);
                setNom("");
                setDescription("");
                onPoutineChanged();
            });
        } else {
            api.put(`/poutine/${id}`, newPoutine).then((response) => {
                const index = poutine.findIndex((poutine) => poutine.id === id);
                const newPoutines = [...poutine];
                newPoutines[index] = response.data;
                setPoutines(newPoutines);
                setNom("");
                setDescription("");
                setId("");
                onPoutineChanged();
            });
        }
    };

    const handleDeleteClick = () => {
        if (id === "") {
            alert("Veuillez sélectionner une poutine à supprimer.");
            return;
        }

        api.delete(`/poutine/${id}`).then(() => {
            const index = poutine.findIndex((poutine) => poutine.id === id);
            const newPoutine = [...poutine];
            newPoutine.splice(index, 1);
            setPoutines(newPoutine);
            setNom("");
            setDescription("");
            setId("");
            onPoutineChanged();
        });
    };

    return (
        <div className={styles}>
            <div>
                <label htmlFor="nom">Nom : </label>
                <input type="text" id="nom" value={nom} onChange={handleNomChange} />
            </div>
            <div>
                <label htmlFor="description">Description : </label>
                <textarea id="description" value={description} onChange={handleDescriptionChange}></textarea>
            </div>
            <div>
                <button onClick={handleNewClick}>Nouveau</button>
                <button onClick={handleSaveClick}>Enregistrer</button>
                <button onClick={handleDeleteClick}>Supprimer</button>
            </div>
        </div>
    );
};

export default FormGestionPoutine;
