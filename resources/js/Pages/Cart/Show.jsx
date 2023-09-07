import React from 'react';
import { InertiaLink } from '@inertiajs/inertia-react'; 
import axios from 'axios';
import GuestLayout from '@/Layouts/GuestLayout';

const Show = ({ cart }) => {
  const removeFromCart = async (productId) => {
    if (confirm('Are you sure you want to remove this product?')) {
      try {
        await axios.delete(`/cart/remove/${productId}`);
        // Show a success message
        alert('Product removed from cart.');
        // Redirect to the cart page
        window.location.href = '/cart';
      } catch (error) {
        console.error('Error removing product from cart:', error);
        // Handle error if needed
      }
    }
  };

  return (
    <GuestLayout>
    <div>
      <h1>Your Cart</h1>
      {cart.length === 0 ? (
        <p>Your cart is empty.</p>
      ) : (
        <table>
          <thead>
            <tr>
              <th>Product</th>
              <th>Price</th>
              <th>Quantity</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            {cart.map((item, index) => (
              <tr key={index}>
                <td>
                  <div className="cart-item">
                  <img src={`/storage/${item.product.imagePr}`} alt="Product Image" />
                    <div>
                      <p>{item.product.titre}</p>
                      
                    </div>
                  </div>
                </td>
                <td>${item.product.prix}</td>
                <td>{item.quantity}</td>
                <td>
                  <button onClick={() => removeFromCart(item.product.id)}>
                    Remove
                  </button>
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      )}

      {/* Link to the checkout page */}
      <InertiaLink href="/checkout">Proceed to Checkout</InertiaLink>
    </div>
    </GuestLayout>
  );
};

export default Show;
