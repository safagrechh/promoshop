import React, { useState, useEffect } from 'react';
import { Link } from '@inertiajs/inertia-react';
import GuestLayout from '@/Layouts/GuestLayout';
import axios from 'axios';

const Show = ({ commande }) => {
    const [pdfUrl, setPdfUrl] = useState(null);

    // Use useEffect to fetch the PDF path when the component mounts
    useEffect(() => {
        fetchPdfPath(commande.id);
    }, [commande.id]);

    const fetchPdfPath = async (commandeId) => {
        try {
            // Send a GET request to the backend to get the PDF path
            const response = await axios.get(`/commandes/${commandeId}/pdf`);
            
            // Get the PDF path from the response
            const pdfPath = response.data.pdf_url;

            // Set the PDF URL to state
            setPdfUrl(pdfPath);
        } catch (error) {
            console.error('Error fetching PDF path:', error);
            // Handle the error if needed
        }
    };

    return (
        <GuestLayout>
            <div>
                <h1>Order Details</h1>
                <p>Total Amount: ${commande.total_amount}</p>
                <p>Address: {commande.address}</p>
                <p>Phone: {commande.phone}</p>

                <h2>Ordered Items</h2>
                <ul>
                    {commande.items.map(item => (
                        <li key={item.id}>
                            <Link href={`/products/${item.product.id}`}>
                                {item.product.titre}
                            </Link> - Quantity: {item.quantity}
                        </li>
                    ))}
                </ul>

                {pdfUrl ? (
                    // Show a link to open the PDF in a new tab
                    <a href={pdfUrl} target="_blank" rel="noopener noreferrer" className="text-blue-600 hover:underline">
                        Open PDF
                    </a>
                ) : (
                    // Show a button to generate the PDF
                    <button onClick={() => fetchPdfPath(commande.id)} className="text-blue-600 hover:underline">
                        Generate PDF
                    </button>
                )}

                <Link href="/mescommandes">Back to Orders</Link>
            </div>
        </GuestLayout>
    );
};

export default Show;
