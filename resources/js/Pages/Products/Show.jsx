import React, { useState } from 'react';
import { InertiaLink } from '@inertiajs/inertia-react';
import axios from 'axios';
import GuestLayout from '@/Layouts/GuestLayout';


const Show = ({ product }) => {
  const [quantity, setQuantity] = useState(1); // Default quantity is 1

  const handleDelete = async () => {
    if (confirm('Are you sure you want to delete this product?')) {
      try {
        await axios.delete(`/products/${product.id}`);
        // Redirect to products index after successful deletion
        window.location.href = '/products';
      } catch (error) {
        console.error('Error deleting product:', error);
        // Handle error if needed
      }
    }
  };

  const addToCart = async () => {
    try {
      await axios.post('/cart/add', {
        product_id: product.id,
        quantity: quantity,
        price : product.prix
      });
      alert('Product added to cart successfully!');
    } catch (error) {
      console.error('Error adding product to cart:', error);
      // Handle error if needed
    }
  };

  return (
    <GuestLayout>
    <div>
      <h1>{product.titre}</h1>
      <p>Description: {product.description}</p>
      <p>Price: {product.prix}</p>
      <p>Category: {product.category_id}</p>

      {product.imagePr && <img src={`/storage/${product.imagePr}`} alt="Product Image" />}
      <div>
        <label htmlFor="quantity">Quantity:</label>
        <input
          type="number"
          id="quantity"
          name="quantity"
          value={quantity}
          onChange={(e) => setQuantity(e.target.value)}
          min="1"
        />
      </div>
      <div>
      <InertiaLink href={`/products/${product.id}/edit`}>Edit</InertiaLink>
        <button onClick={handleDelete} style={{ marginRight: '8px' }}>Delete</button>
        <button onClick={addToCart} style={{ marginRight: '8px' }}>Add to Cart</button>
        <InertiaLink href="/products">Back</InertiaLink>
      </div>
    </div></GuestLayout>
  );
};

export default Show;
