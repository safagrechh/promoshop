// resources/js/components/commande.jsx

import React from 'react';

const Commande = ({ commande }) => {
    return (
        <div>
            <h1>Commande Details</h1>
            <p>Total Amount: {commande.total_amount}</p>
            <p>Address: {commande.address}</p>
            <p>Phone: {commande.phone}</p>

            <h2>Ordered Items</h2>
            <ul>
                {commande.items.map(item => (
                    <li key={item.id}>
                        {/* Render your ordered item details */}
                    </li>
                ))}
            </ul>
            {/* Add a button to generate PDF */}
            <button>Generate PDF</button>
        </div>
    );
};

export default Commande;
