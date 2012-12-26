
 {if $Basket->getCount()!=0}
        	<div class="basket">
                {*if $user->isAuthenticated()*}
                     <a id="bag" href="{$SITE_URL}/order/basket/">Ваша корзина: {$Basket->getCount()}</a>
                {*else}
                     <a id="bag" href="{$SITE_URL}/info/check/">Ваша корзина:</a>
                {/if}
                     <p> {$Basket->getCount()}</p>
                
                     <a id="conf" href="{$SITE_URL}/order/basket/">Оформить заказ</a>*}
             
        	</div>
    {/if}