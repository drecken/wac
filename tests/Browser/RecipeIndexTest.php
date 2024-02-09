<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RecipeIndexTest extends DuskTestCase
{

    public function test_if_pagination_retains_search_parameters(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/recipes')
                ->pause(200)
                ->assertSee('Recipes')
                ->type('#ingredient', 'potato')
                ->press('Search')
                ->pause(200)
                ->assertSee('Showing 1 to 10 of 13 results.')
                ->screenshot('recipe-search-p1')
                ->clickLink('2')
                ->pause(200)
                ->assertSee('Showing 11 to 13 of 13 results.')
                ->assertQueryStringHas('filter', ['ingredient' => 'potato'])
                ->screenshot('recipe-search-p2');
        });
    }

    public function test_recipe_show_page()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/recipes')
                ->pause(200)
                ->type('#keyword', 'Mediterranean')
                ->press('Search')
                ->pause(200)
                ->clickLink('Mediterranean Cod en Papillote')
                ->pause(200)
                ->screenshot('recipe-show');
        });
    }

    public function test_recipe_index()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/recipes')
                ->pause(200)
                ->screenshot('recipe-index')
                ->assertSee('Recipes')
                ->assertSee('Showing 1 to 10 of 47 results.');
        });
    }

    public function test_if_email_is_exact_search()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/recipes')
                ->pause(200)
                ->keys('#email', 'foo@bar.co', '{enter}')
                ->pause(200)
                ->assertSee('No results.')
                ->screenshot('recipe-email-exact-search-p1')
                ->keys('#email', 'm', '{enter}')
                ->pause(200)
                ->assertSee('Showing 1 to 10 of 11 results.')
                ->screenshot('recipe-email-exact-search-p2');
        });
    }

    public function test_recipe_index_search()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/recipes')
                ->pause(200)
                ->keys('#email', 'foo@bar.com', '{enter}')
                ->pause(200)
                ->assertSee('Showing 1 to 10 of 11 results.')
                ->keys('#ingredient', 'potato', '{enter}')
                ->pause(200)
                ->assertSee('Showing 1 to 4 of 4 results.');

            $browser->visit('/recipes')
                ->pause(200)
                ->keys('#ingredient', 'potato', '{enter}')
                ->pause(200)
                ->assertSee('Showing 1 to 10 of 13 results.')
                ->keys('#keyword', 'scallop', '{enter}')
                ->pause(200)
                ->assertSee('Showing 1 to 6 of 6 results.');

            $browser->visit('/recipes')
                ->pause(200)
                ->keys('#keyword', 'scallop', '{enter}')
                ->pause(200)
                ->assertSee('Showing 1 to 10 of 12 results.')
                ->keys('#email', 'foo@bar.com', '{enter}')
                ->pause(200)
                ->assertSee('Showing 1 to 3 of 3 results.')
                ->keys('#ingredient', 'potato', '{enter}')
                ->pause(200)
                ->assertSee('Showing 1 to 1 of 1 results.')
                ->screenshot('recipe-and-condition-search')
                ->clickLink('One of each')
                ->pause(200)
                ->assertSee('foo@bar.com')
                ->assertSee('potato')
                ->assertSee('scallop')
                ->screenshot('recipe-and-condition-show');
        });
    }
}
