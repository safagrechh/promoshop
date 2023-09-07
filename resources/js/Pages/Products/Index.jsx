import React from 'react';
import { InertiaLink } from '@inertiajs/inertia-react';
import GuestLayout from '@/Layouts/GuestLayout';

const Index = ({ products }) => (
  <GuestLayout>
    <div>
      <h1>Products</h1>
      <InertiaLink href="/product/create">Create Product</InertiaLink>
      <ul>
        {products.map((product) => (
          <li key={product.id}>
            <InertiaLink href={`/products/${product.id}`}>{product.titre}</InertiaLink>
            {product.imagePr && <img src={`/storage/${product.imagePr}`} alt="Product Image" />}
            
          </li>
        ))}
      </ul>
      <InertiaLink href="/mescommandes" className="text-blue-600 hover:underline">
  Voir mes commandes
</InertiaLink>

    </div></GuestLayout>
  );
  
  export default Index;
  
