<template>
    <form @submit.prevent>
        <input type="hidden" name="product_id" id="product_id" v-model="productId">
        <div class="form-group" v-if="isExpanded">
            <label for="quantity" class="sr-only">Hoeveelheid</label>
            <input type="number" name="quantity" id="quantity" v-model="quantity">
        </div>
        <button type="submit">
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
        }
	};
</script>

<style scoped>

</style>