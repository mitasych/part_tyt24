{*<div class="right_part2" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
     <div class="bg_ie" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
</div>*}

<div>
    <div class="main_top_text">

        {breadcrumb controller="users" alias="profile" altTitle="Личный кабинет"}


        {include file="lmenu.tpl"}
        
        {foreach from=$orders item=toplink key=key name=fn}
        
        	<div class="horizont_box1">
        		<div class="promo_left">
        		<style>
					.main_top_text_contacts {
						top: 42px;
					}
				</style>
	        		<div class="promo_box_link" style="margin: 0 0 5px 0">
	        			<div>
	        				<h1>{$toplink.title}</h1>
	        			</div>
	        			<div class="promo_box_i inf">
	        				<span><b>Информационная версия</b></span>
	        				<span>В электронном виде на e-mail</span>
	        			</div>
	        			{if $ofreports == 1}
						<div class="promo_box_i of_ver">
							<span><b>Официальная версия</b></span>
							<span>Заверено печатью, доставка курьером</span>
						</div>
						{/if}
	        		</div>
	        		<div class="promo_content">
		        		<div class="promo_content_main_form">
		        			<div class="pr_left">
		        				<div class="pr_right_bg">
		        					<a href="{$toplink.link}" class="promo_box_link">
		        						<img src="/upload/menu/{$toplink.image}" alt="" title="" width="150" height="150">
		        					</a>
		        				</div>
		        			</div>
		        			<div class="pr_right">
		        				<table style="width:600px;">
		        					{assign var="sub1" value=$toplink.orders[0]}
		        					{assign var="sub2" value=$toplink.orders[1]}
		        					<tr>
		        						<td width="50%" style="padding: 5px; vertical-align: top;">
		        							<div class="promo_content_title">
		        								<h3>
		        									<span>
		        										<a style="float: left;" href="{$sub1->url}">
		        											{$sub1->title|escape:html}
		        										</a>
		        									</span>
		        									<span class="promo_content_det_inf">
		        										<a href="{$sub1->url}">
		        											<!--<img src="http://egr16.dev/images/info_details.jpg" style="margin: 0px;" alt="">-->
		        											<img src="{$IMG_URL}/info_det_one_min.png" alt="">
		        											<img src="{$IMG_URL}/info_det_one_min.png" alt="">
		        											<img src="{$IMG_URL}/info_det_one_min.png" alt="">
		        										</a>
		        									</span>
		        								</h3>
		        							</div>
		        						</td>
		        						<td width="50%" style="padding: 5px; vertical-align: top;">
		        							<div class="promo_content_title">
		        								<h3>
		        									<span>
		        										<a style="float: left;" href="{$sub2->url}">
		        											{$sub2->title|escape:html}
		        										</a>
		        									</span>
		        									<span class="promo_content_det_inf">
		        										<a href="{$sub2->url}">
		        											<!--<img src="http://egr16.dev/images/info_details.jpg" style="margin: 0px;" alt="">-->
			        										<img src="http://egr16.dev/images/info_det_one_min.png" alt="">
			        										<img src="http://egr16.dev/images/info_det_one_min.png" alt="">
			        										<img src="http://egr16.dev/images/info_det_one_min.png" alt="">
		        										</a>
		        									</span>
		        								</h3>
		        							</div>
		        						</td>
		        					</tr>
		        					<tr>
		        						<td style="padding:5px; vertical-align:top;">
		        							<div class="text_mini">
		        								{$sub1->text_mini}
		        							</div>
		        							<div>
												<ul>
			                                        {if $sub1->flag1 && ($sub1->flag2 || $sub1->flag3) && $ofreports == 1}
			                                        <li class="p_box_i inf_main_block">
														<span>
															Стоимость от {$sub1->getPricesMin(1)}
														</span>
														<span class="exmpl">
															<a href="#">пример</a>
														</span>
			                                        </li>
			                                                                                    
			                                        <li class="p_box_i of_ver_main_block">
														<span>
															Стоимость от {if $sub1->flag2}{$sub1->getPricesMin(2)}{elseif $sub1->flag3}{$sub1->getPricesMin(3)}{/if}
															<!-- </strong> -->
														</span>
														<span class="exmpl">
															<a href="#">пример</a>
														</span>
			                                        </li>
			                                        {elseif ($sub1->flag1 && !$sub1->flag2 && !$sub1->flag3) || ($sub1->flag1 && $ofreports != 1)}
			                                                                                
			                                        <!-- по выбору выводить time_main_block -->
			                                        <li class="p_box_i time_main_block">
			                                            <span>
			                                                Сроки {$sub1->getTimePrint(1)}
			                                            </span>
			                                            <span class="exmpl">
			                                                <a href="#">пример</a>
			                                            </span>
			                                        </li>
			                                        <!-- -->
			
			                                        <li class="p_box_i inf_main_block">
			                                            <span>
			                                                Стоимость от {$sub1->getPricesMin(1)}
			                                                <!-- </strong> -->
			                                            </span>
			                                            <span class="exmpl">
			                                                <a href="#">пример</a>
			                                            </span>
			                                        </li>
			                                        {/if}
												</ul>
											</div>
		        							<div>
												<div class="exmpl_order">
													<a href="{$sub1->url}">
														Подробнее
													</a> 
												</div>
												{if $sub1->url[0] != 'h'}
												<div class="order">
													<a class="ordr_link" href="/reports/order/id/{$sub1->id}">
														Заказать
													</a>
												</div>
												{/if}
											</div>
		        						</td>
		        						<td style="padding:5px; vertical-align:top;">
		        							<div class="text_mini">
		        								{$sub2->text_mini}
		        							</div>
		        							<div>
												<ul>
													{if $sub2->flag1 && ($sub2->flag2 || $sub2->flag3) && $ofreports == 1}
			                                        <li class="p_box_i inf_main_block">
														<span>
															Стоимость от {$sub2->getPricesMin(1)}
														</span>
														<span class="exmpl">
															<a href="#">пример</a>
														</span>
			                                        </li>
			                                                                                    
			                                        <li class="p_box_i of_ver_main_block">
														<span>
															Стоимость от {if $sub2->flag2}{$sub2->getPricesMin(2)}{elseif $sub2->flag3}{$sub2->getPricesMin(3)}{/if}
															<!-- </strong> -->
														</span>
														<span class="exmpl">
															<a href="#">пример</a>
														</span>
			                                        </li>
			                                        {elseif ($sub2->flag1 && !$sub2->flag2 && !$sub2->flag3) || ($sub2->flag1 && $ofreports != 1)}
			                                                                                
			                                        <!-- по выбору выводить time_main_block -->
			                                        <li class="p_box_i time_main_block">
			                                            <span>
			                                                Сроки {$sub2->getTimePrint(1)}
			                                            </span>
			                                            <span class="exmpl">
			                                                <a href="#">пример</a>
			                                            </span>
			                                        </li>
			                                        <!-- -->
			
			                                        <li class="p_box_i inf_main_block">
			                                            <span>
			                                                Стоимость от {$sub2->getPricesMin(1)}
			                                                <!-- </strong> -->
			                                            </span>
			                                            <span class="exmpl">
			                                                <a href="#">пример</a>
			                                            </span>
			                                        </li>
			                                        {/if}
												</ul>
											</div>
		        							<div>
												<div class="exmpl_order">
														<a href="{$sub2->url}">
															Подробнее
														</a> 
												</div>
												{if $sub2->url[0] != 'h'}
												<div class="order">
													<a class="ordr_link" href="/reports/order/id/{$sub2->id}">
														Заказать
													</a>
												</div>
												{/if}
											</div>
		        						</td>
		        					</tr>
		        				</table>
		        			</div>
		        		</div>
		        	</div>
	        	</div>
        	</div>
        
        {/foreach}

        <div class="dotted2"></div>
    </div>
</div>
