import React, { useState } from 'react';
import { Inertia } from '@inertiajs/inertia-react';
import axios from 'axios';
import GuestLayout from '@/Layouts/GuestLayout';


const Create = ({ categories }) => {
  const [form, setForm] = useState({
    titre: '',
    description: '',
    prix: '',
    category_id: '',
    imagePr: null,
  });
  const [formErrors, setFormErrors] = useState({});

  const handleImageChange = (event) => {
    setForm({ ...form, imagePr: event.target.files[0] });
  };

  const submitForm = async (event) => {
    event.preventDefault();
    setFormErrors({});

    const csrfToken = document.head.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const requestBody = {
      titre: form.titre,
      description: form.description,
      prix: form.prix,
      category_id: form.category_id,
      imagePr: form.imagePr,
    };
  
   

    try {
      const response = await axios.post(`/products/store`, requestBody, {
        headers: {
          'Content-Type': 'multipart/form-data',
          'X-CSRF-TOKEN': csrfToken, // Important for sending FormData
        },
        params: {
          _method: 'POST', // Indicate that it's a PUT request
        },
      });
  
      
      if (response.status === 200) {
        // Success, redirect to the products list
        window.location.href = '/products';
      } else if (response.status === 422) {
        const errorData = response.data;
        if (errorData.errors) {
          setFormErrors(errorData.errors);
        }
      }
    } catch (error) {
      console.error('Error:', error);
    }
  };

  
  return (
    <GuestLayout>
    <div>
      <h1>Create Product</h1>
      <form onSubmit={submitForm}>
        <div>
          <label htmlFor="titre">Title</label>
          <input type="text" id="titre" value={form.titre} onChange={(e) => setForm({ ...form, titre: e.target.value })} />
          {formErrors.titre && <div className="error">{formErrors.titre[0]}</div>}
        </div>
        <div>
          <label htmlFor="description">Description</label>
          <textarea id="description" value={form.description} onChange={(e) => setForm({ ...form, description: e.target.value })}></textarea>
          {formErrors.description && <div className="error">{formErrors.description[0]}</div>}
        </div>
        <div>
          <label htmlFor="prix">Price</label>
          <input type="number" id="prix" value={form.prix} onChange={(e) => setForm({ ...form, prix: e.target.value })} />
          {formErrors.prix && <div className="error">{formErrors.prix[0]}</div>}
        </div>
        <div>
          <label htmlFor="category_id">Category</label>
          <select id="category_id" value={form.category_id} onChange={(e) => setForm({ ...form, category_id: e.target.value })}>
            <option value="">Select a category</option>
            {categories.map((category) => (
              <option key={category.id} value={category.id}>{category.titre}</option>
            ))}
          </select>
          {formErrors.category_id && <div className="error">{formErrors.category_id[0]}</div>}
        </div>
        <div>
          <label htmlFor="imagePr">Image</label>
          <input type="file" id="imagePr" onChange={handleImageChange} />
          {formErrors.imagePr && <div className="error">{formErrors.imagePr[0]}</div>}
        </div>
        <button type="submit">Create Product</button>
      </form>
    </div>
    </GuestLayout>
  );
  
};

export default Create;
