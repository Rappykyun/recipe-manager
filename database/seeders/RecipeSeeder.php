<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Recipe;
use App\Models\Tag;
use App\Models\User;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Create a test user if none exists
        $user = User::first();
        if (!$user) {
            $user = User::create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]);
        }

        // Create tags
        $tags = [
            'Vegetarian',
            'Quick',
            'Healthy',
            'Comfort Food',
            'Gluten-Free',
            'Low-Carb',
            'Spicy',
            'Sweet',
        ];

        $tagModels = [];
        foreach ($tags as $tagName) {
            $tagModels[] = Tag::firstOrCreate(['name' => $tagName]);
        }

        // Sample recipes
        $recipes = [
            [
                'title' => 'Classic Pancakes',
                'description' => 'Fluffy and delicious pancakes perfect for breakfast. Easy to make and loved by everyone.',
                'category' => 'Breakfast',
                'prep_time' => 15,
                'is_public' => true,
                'image_url' => 'https://images.unsplash.com/photo-1567620905732-2d1ec7ab7445?w=500',
                'ingredients' => [
                    ['name' => 'All-purpose flour', 'quantity' => '2 cups'],
                    ['name' => 'Sugar', 'quantity' => '2 tablespoons'],
                    ['name' => 'Baking powder', 'quantity' => '2 teaspoons'],
                    ['name' => 'Salt', 'quantity' => '1/2 teaspoon'],
                    ['name' => 'Milk', 'quantity' => '1 3/4 cups'],
                    ['name' => 'Eggs', 'quantity' => '2 large'],
                    ['name' => 'Butter', 'quantity' => '1/4 cup melted'],
                ],
                'tags' => ['Quick', 'Sweet'],
            ],
            [
                'title' => 'Vegetable Stir Fry',
                'description' => 'A healthy and colorful vegetable stir fry that\'s quick to prepare and packed with nutrients.',
                'category' => 'Dinner',
                'prep_time' => 20,
                'is_public' => false,
                'image_url' => 'https://images.unsplash.com/photo-1512058564366-18510be2db19?w=500',
                'ingredients' => [
                    ['name' => 'Mixed vegetables', 'quantity' => '4 cups'],
                    ['name' => 'Soy sauce', 'quantity' => '3 tablespoons'],
                    ['name' => 'Garlic', 'quantity' => '3 cloves minced'],
                    ['name' => 'Ginger', 'quantity' => '1 tablespoon minced'],
                    ['name' => 'Vegetable oil', 'quantity' => '2 tablespoons'],
                    ['name' => 'Sesame oil', 'quantity' => '1 teaspoon'],
                ],
                'tags' => ['Vegetarian', 'Healthy', 'Quick'],
            ],
            [
                'title' => 'Chicken Caesar Salad',
                'description' => 'A classic Caesar salad with grilled chicken, crispy croutons, and homemade dressing.',
                'category' => 'Lunch',
                'prep_time' => 25,
                'is_public' => true,
                'image_url' => 'https://images.unsplash.com/photo-1546793665-c74683f339c1?w=500',
                'ingredients' => [
                    ['name' => 'Chicken breast', 'quantity' => '2 pieces'],
                    ['name' => 'Romaine lettuce', 'quantity' => '1 large head'],
                    ['name' => 'Parmesan cheese', 'quantity' => '1/2 cup grated'],
                    ['name' => 'Croutons', 'quantity' => '1 cup'],
                    ['name' => 'Caesar dressing', 'quantity' => '1/4 cup'],
                ],
                'tags' => ['Healthy'],
            ],
            [
                'title' => 'Chocolate Chip Cookies',
                'description' => 'Soft and chewy chocolate chip cookies that are perfect for any occasion.',
                'category' => 'Dessert',
                'prep_time' => 30,
                'is_public' => true,
                'image_url' => 'https://images.unsplash.com/photo-1499636136210-6f4ee915583e?w=500',
                'ingredients' => [
                    ['name' => 'All-purpose flour', 'quantity' => '2 1/4 cups'],
                    ['name' => 'Butter', 'quantity' => '1 cup softened'],
                    ['name' => 'Brown sugar', 'quantity' => '3/4 cup'],
                    ['name' => 'White sugar', 'quantity' => '3/4 cup'],
                    ['name' => 'Eggs', 'quantity' => '2 large'],
                    ['name' => 'Vanilla extract', 'quantity' => '2 teaspoons'],
                    ['name' => 'Chocolate chips', 'quantity' => '2 cups'],
                ],
                'tags' => ['Sweet', 'Comfort Food'],
            ],
            [
                'title' => 'Quinoa Buddha Bowl',
                'description' => 'A nutritious and colorful bowl packed with quinoa, vegetables, and a tahini dressing.',
                'category' => 'Lunch',
                'prep_time' => 35,
                'is_public' => false,
                'image_url' => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=500',
                'ingredients' => [
                    ['name' => 'Quinoa', 'quantity' => '1 cup'],
                    ['name' => 'Sweet potato', 'quantity' => '1 large cubed'],
                    ['name' => 'Chickpeas', 'quantity' => '1 can drained'],
                    ['name' => 'Spinach', 'quantity' => '2 cups'],
                    ['name' => 'Avocado', 'quantity' => '1 sliced'],
                    ['name' => 'Tahini', 'quantity' => '3 tablespoons'],
                    ['name' => 'Lemon juice', 'quantity' => '2 tablespoons'],
                ],
                'tags' => ['Vegetarian', 'Healthy', 'Gluten-Free'],
            ],
        ];

        foreach ($recipes as $recipeData) {
            $ingredients = $recipeData['ingredients'];
            $tagNames = $recipeData['tags'];
            unset($recipeData['ingredients'], $recipeData['tags']);

            $recipe = Recipe::create([
                ...$recipeData,
                'user_id' => $user->id,
            ]);

            // Add ingredients
            foreach ($ingredients as $ingredient) {
                $recipe->ingredients()->create($ingredient);
            }

            // Add tags
            $tagIds = [];
            foreach ($tagNames as $tagName) {
                $tag = collect($tagModels)->firstWhere('name', $tagName);
                if ($tag) {
                    $tagIds[] = $tag->id;
                }
            }
            $recipe->tags()->sync($tagIds);
        }
    }
}
