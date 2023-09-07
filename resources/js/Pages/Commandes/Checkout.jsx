import React, { useState } from 'react';
import axios from 'axios';
import GuestLayout from '@/Layouts/GuestLayout';


const Checkout = ({ cart }) => {
  const [address, setAddress] = useState('');
  const [phone, setPhone] = useState('');

  const calculateTotalAmount = () => {
    let total = 0;
    cart.forEach((item) => {
      total += item.product.prix * item.quantity;
    });
    return total;
  };

  const handleCheckout = async () => {
    try {
      const response = await axios.post('/commandes', {
        items: cart,
        total_amount: calculateTotalAmount(),
        address: address,
        phone: phone,
      });

      // Handle success (e.g., show a success message, redirect, etc.)
      alert('Order placed successfully.');
      
      // Redirect to a success page or elsewhere
      window.location.href = '/mescommandes';
    } catch (error) {
      console.error('Error creating order:', error);
      // Handle error if needed
    }
  };

  return (
    <GuestLayout>
    <div>
      <h1>Checkout</h1>
      {cart.length === 0 ? (
        <p>Your cart is empty.</p>
      ) : (
        <div>
          <table>
            <thead>
              <tr>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
              </tr>
            </thead>
            <tbody>
              {cart.map((item, index) => (
                <tr key={index}>
                  <td>{item.product.titre}</td>
                  <td>${item.product.prix}</td>
                  <td>{item.quantity}</td>
                </tr>
              ))}
            </tbody>
          </table>
          <p>Total Amount: ${calculateTotalAmount()}</p>
        </div>
      )}

      {/* Other form inputs for address and phone */}
      <input
        type="text"
        placeholder="Address"
        value={address}
        onChange={(e) => setAddress(e.target.value)}
      />
      <input
        type="text"
        placeholder="Phone"
        value={phone}
        onChange={(e) => setPhone(e.target.value)}
      />

      {/* Button to initiate checkout */}
      <button onClick={handleCheckout}>Place Order</button>
    </div></GuestLayout>
  );
};

export default Checkout;
