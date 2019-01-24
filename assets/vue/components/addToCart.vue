<template>
    <form @submit.prevent="addToCart">
        <input type="hidden" name="product_id" id="product_id" v-model="productId" v-if="isExpanded">
        <div class="form-group" v-if="isExpanded">
            <label for="quantity" class="sr-only">Hoeveelheid</label>
            <input type="number" name="quantity" id="quantity" v-model="quantity">
        </div>
        <button type="submit" class="submit-button">
            <i class="fas fa-shopping-cart"></i>
        </button>
    </form>
</template>

<script>
	export default {
		name: "addToCart",
        data() {
			return {
				quantity: 1
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
                const data = {
                    action: 'add_to_cart',
                    product_id: this.productId,
                    quantity: this.quantity,
                };
                
                console.log(data)
                this.$http
                    .post('wp/admin/admin-ajax.php', data)
                    .then(res => {
                    	console.log(res)
                    })
                    .catch(err => console.warn(err))
            }
        }
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
</style>