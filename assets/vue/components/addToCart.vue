<template>
    <form @submit.prevent>
        <input type="hidden" name="product_id" id="product_id" v-model="productId">
    </form>
</template>

<script>
	export default {
		name: "addToCart",
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