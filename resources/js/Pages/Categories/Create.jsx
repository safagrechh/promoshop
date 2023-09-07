import { useForm } from '@inertiajs/inertia-react';

export default function Create() {
  const { data, setData, post, errors } = useForm({
    titre: '',
    description: '',
  });

  const handleSubmit = (e) => {
    e.preventDefault();
    post(route('categories.store'), data);
  };

  return (
    <div>
      <h1>Create Category</h1>
      <form onSubmit={handleSubmit}>
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
          <button type="submit">Create Category</button>
        </div>
      </form>
    </div>
  );
}
