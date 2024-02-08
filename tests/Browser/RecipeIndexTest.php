<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RecipeIndexTest extends DuskTestCase
{

    public function testExample(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/recipes')
                ->pause(200)
                ->assertSee('Recipes')
                ->screenshot('recipe-index')
                ->type('#keyword', 'cheese')
                ->pause(200)
                ->screenshot('recipe-cheese')
                ->press('Search')
                ->pause(200)
                ->screenshot('recipe-search')
                ->storeConsoleLog('console');
        });
    }
}
