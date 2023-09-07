import { InertiaLink } from '@inertiajs/inertia-react';

export default function Index({ categories }) {
  return (
    <div>
      <h1>Categories</h1>
      <ul>
        {categories.map(category => (
          <li key={category.id}>
            <InertiaLink href={route('categories.show', category.id)}>
              {category.titre}
            </InertiaLink>
          </li>
        ))}
      </ul>
      <InertiaLink href={route('categories.create')}>Create New Category</InertiaLink>
    </div>
  );
}
