import React from 'react';
import GuestLayout from '@/Layouts/GuestLayout';
import { InertiaLink } from '@inertiajs/inertia-react';

const UserCommandes = ({ commandes }) => {
  return (
    <GuestLayout>
      <div className="container mx-auto py-6">
        <h1 className="text-3xl font-semibold">Mes Commandes</h1>

        {commandes.length === 0 ? (
          <p>Vous n'avez pas encore passé de commandes.</p>
        ) : (
          <ul>
            {commandes.map((commande) => (
              <li key={commande.id} className="mb-4">
                <h2 className="text-xl font-semibold">
                  Commande #{commande.id}
                </h2>
                <p>Total: ${commande.total_amount}</p>
                <p>Adresse de livraison: {commande.address}</p>
                <p>Téléphone: {commande.phone}</p>
                <InertiaLink
                  href={route('commandes.show', commande.id)}
                  className="text-blue-600 hover:underline"
                >
                  Voir les détails de la commande
                </InertiaLink>
              </li>
            ))}
          </ul>
        )}
      </div>
    </GuestLayout>
  );
};

export default UserCommandes;
