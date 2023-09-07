import { useForm } from '@inertiajs/inertia-react';
import { InertiaLink } from '@inertiajs/inertia-react';

export default function Edit({ category }) {
  const { data, setData, put, delete: deleteCategory, errors } = useForm({
    titre: category.titre,
    description: category.description,
  });

  const handleUpdate = (e) => {
    e.preventDefault();
    put(route('categories.update', category.id), data);
  };

  const handleDelete = () => {
    if (confirm('Are you sure you want to delete this category?')) {
      deleteCategory(route('categories.destroy', category.id));
    }
  };

  return (
    <div>
      <h1>Edit Category: {category.titre}</h1>
      <form onSubmit={handleUpdate}>
        <div>
          <label>Titre:</label>
          <input
            type="text"
            value={data.titre}
            onChange={(e) => setData('titre', e.target.value)}
          />
          {errors.titre && <div>{errors.titre}</div>}
        </div>
        <div>
          <label>Description:</label>
          <textarea
            value={data.description}
            onChange={(e) => setData('description', e.target.value)}
          />
          {errors.description && <div>{errors.description}</div>}
        </div>
        <div>
          <button type="submit">Update Category</button>
          <button type="button" onClick={handleDelete}>Delete Category</button>
        </div>
      </form>
      <InertiaLink href={route('categories.show', category.id)}>Back to Category</InertiaLink>
    </div>
  );
}
