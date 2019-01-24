<template>
    <form @submit.prevent="addToCart">
        <input type="hidden" name="product_id" id="product_id" v-model="productId" v-if="isExpanded">
        <div class="form-group d-flex" v-if="isExpanded">
            <label for="quantity" class="sr-only">Hoeveelheid</label>
            <button type="button" class="button-minus" @click="lowerQuantity">-</button>
            <input type="number" min="1" name="quantity" id="quantity" v-model="quantity">
            <button type="button" class="button-plus" @click="quantity++">+</button>
        </div>
        
        <div class="form-group" v-if="isExpanded">
            <button class="expanded-submit-button" type="submit">Bestellen</button>
        </div>
        
        <button type="submit" class="submit-button" v-if="!isExpanded">
            <i class="fas fa-shopping-cart"></i>
        </button>
        
        <transition name="fade">
            <section v-if="isSuccess" class="alert alert-success">
                {{ productName }} is {{ quantity }}x aan uw winkelwagen toegevoegd
            </section>
            <section v-if="isFailed" class="alert alert-warning">
                Het is niet gelukt om {{ productName }} aan uw winkelwagen toe te voegen.
            </section>
        </transition>
    </form>
</template>

<script>
	export default {
		name: "addToCart",
        data() {
			return {
				quantity: 1,
                isLoading: false,
                isSuccess: false,
                isFailed: false,
                productName: null
            }
        },
        props: {
			isExpanded: {
				type: Boolean,
                default: false,
            },
            productId: {
				type: Number,
                required: true,
            }
        },
        methods: {
			addToCart() {
				this.$el.querySelector('.submit-button').disabled = true;
                const data = {
                    'product_id': this.productId,
                    'quantity': this.quantity,
                };
                
                this.$http
                    .post('wp-admin/admin-ajax.php/?action=add_to_cart', data)
                    .then(res => {
						this.$el.querySelector('.submit-button').disabled = false;
						this.isSuccess = true;
						this.productName = res.data.data.product
                    })
                    .catch(err => {
						this.$el.querySelector('.submit-button').disabled = false;
						console.error(err);
					})
            },
            
            lowerQuantity() {
				if(this.quantity > 1) {
					this.quantity--
                }
            }
        },
	};
</script>

<style scoped lang="sass">
.submit-button
    background: var(--primary)
    -webkit-border-radius: 5px
    -moz-border-radius: 5px
    border-radius: 5px
    border: 0
    padding: 5px 10px
    color: var(--white)
    -webkit-transition: all 0.3s
    -moz-transition: all 0.3s
    -ms-transition: all 0.3s
    -o-transition: all 0.3s
    transition: all 0.3s
    &:hover
        background: var(--primary-opaque-20)
        cursor: pointer
    &[disabled]
        background-color: var(--gray)


.expanded-submit-button
    @extend .submit-button
    background: #41A043
    width: 100%
    padding: 10px 20px

#quantity
    -webkit-appearance: textfield
    -moz-appearance: textfield
    appearance: textfield
    border: 1px solid var(--primary-dark-10)
    border-left: 0
    border-right: 0
    margin: 0
    height: 45px
    text-align: center

.button-minus, .button-plus
    @extend .submit-button
    background: var(--primary-dark-10)
    padding: 10px 20px

.button-minus
    border-top-right-radius: 0
    border-bottom-right-radius: 0
    
.button-plus
    border-top-left-radius: 0
    border-bottom-left-radius: 0

.fade-enter-active, .fade-leave-active
    transition: opacity .5s

.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */
    opacity: 0
</style>