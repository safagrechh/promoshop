import React from 'react';
import { Link } from '@inertiajs/inertia-react';
import GuestLayout from '@/Layouts/GuestLayout';
import axios from 'axios';

const Show = ({ commande }) => {
    const generatePdf = async (commandeId) => {
        try {
            // Send a GET request to the backend to generate the PDF
            const response = await axios.get(`/commandes/${commandeId}/pdf`, {
                responseType: 'blob', // Specify the response type as arraybuffer
            });

            // Create a blob from the response data
            const blob = new Blob([response.data], { type: 'application/pdf' });

            // Create a blob URL for the PDF
            const url = window.URL.createObjectURL(blob);

            // Open the PDF in a new tab
            window.open(url);
        } catch (error) {
            console.error('Error generating PDF:', error);
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

                {/* Pass the commande.id to the generatePdf function */}
                <a
                    href="#"
                    onClick={() => generatePdf(commande.id)}
                    className="text-blue-600 hover:underline"
                >
                    Generate PDF
                </a>

                <Link href="/mescommandes">Back to Orders</Link>
            </div>
        </GuestLayout>
    );
};

export default Show;
