<template lang="pug">
mixin select(clickCallback, blurCallback, target, selected, selectedKey)
    span.sec-back.has-border-radius.my-1.d-flex.justify-content-center.align-items-center.px-3.chevron-back.position-relaitve.cursor-pointer(class!=attributes.class, id!=attributes.id, @click=clickCallback, @blur=blurCallback)
        span(data-target!=target)= selected
        input(type="hidden", disabled, name!=target, id!=target, value=selectedKey)
        if block
            block

mixin list()
    ul.pt-1.pb-0.has-border-radius(class=attributes.class)
        if block
            block
    
div.vmw__special__search.has-border-radius
    form.text-center.text-white.font-weight-bold.d-flex.flex-column.p-2(@submit.prevent="submitData")
        p.m-0.mb-1 Ik ben op zoek naar
        +select("changeCategoryOpen", "changeCategoryOpen", 'product-category', "{{ categories.rood }}", "rood")
            +list(class='filter-category')
                li.p-1.border-bottom.hover-me-timbers(v-for="(category, key) in categories", :key="key", :data-category="key", @click="selectCategory") {{ category }}
        +select("changePrijsOpen", "changePrijsOpen", 'product-price', "{{ prijzen[0].name }}", "")
            +list.filter-price
                li.p-1.border-bottom.hover-me-timbers(v-for="(prijs, index) in prijzen", :key="index", :data-price="prijs.key", @click="selectPrijs",  v-html="prijs.name") {{ index }}
        button.btn.bg-white.text-dark.has-border-radius(type="submit") Toon resultaat
</template>

<script lang="ts">
export default {
	mounted(){},
    data() {
		return {
			categories: {
				'rood': 'Rode wijn',
                'wit': 'Witte wijn',
                'rose': 'Rose wijn',
                'dessert': 'Dessert wijn',
                'mousserend': 'Mousserende wijn'
            },
            prijzen: [
				{
					key: '',
					name: 'alle prijzen',
				},
				{
					key: '5-7',
					name: '&euro; 5 tot &euro; 7'
				},
				{
					key: '5-15',
					name: '&euro; 7 tot &euro; 15'
				},
				{
					key: '15-25',
					name: '&euro; 15 tot &euro; 25',
				},
				{
					key: '25',
					name: '&euro; 25 +'
				}
            ]
        }
    },
    props: {
		url: {
			type: String,
            default: 'https://casadelvino.nl/winkel/',
        },
    },
    methods: {
		submitData() {
			let prijs = (<HTMLInputElement>document.querySelector('#product-price')).value;
			let category = (<HTMLInputElement>document.querySelector('#product-category')).value;
			
			let params = new URLSearchParams();
			if (prijs !== '') {
				params.append('product-price', prijs);
            }
			let pUrl = `${this.url}/${category}?${params.toString()}`;
			
            window.location.href = pUrl
        },
        changeCategoryOpen(event) {
            (<Element>event.target).closest('.chevron-back').classList.toggle('up');
			document.querySelector('.filter-category').classList.toggle('active');
        },
        changePrijsOpen(event) {
			(<Element>event.target).closest('.chevron-back').classList.toggle('up');
			document.querySelector('.filter-price').classList.toggle('active');
        },
        selectCategory(ev) {
			let k = ev.target.dataset.category;
            (<HTMLInputElement>document.querySelector('input#product-category')).value = k;
			document.querySelector('[data-target="product-category"]').innerHTML = this.categories[k];
			this.allChevronDown();
        },
		selectPrijs: function (ev) {
			let k = ev.target.dataset.price;
            (<HTMLInputElement>document.querySelector('input#product-price')).value = k;
			this.prijzen.forEach( ob => {
				if( ob.key === k) {
					document.querySelector('[data-target="product-price"]').innerHTML = ob.name
				}

			});
			this.allChevronDown();
		},
		allChevronDown: function () {
			document.querySelectorAll('.chevron-back').forEach( el => {
				el.classList.remove('up')
			})
		},
		closeAll: function () {
			this.allChevronDown();
			document.querySelector('.filter-category').classList.remove('active');
			document.querySelector('.filter-price').classList.remove('active')
		}
    },
}
</script>

<style lang="scss" scoped>
    @import 'https://use.fontawesome.com/releases/v5.7.0/css/all.css';
    $prim: #69796B;
    $sec: #445846;

    * {
        font-family: "Open Sans";
        font-weight: 300;
    }

    .cursor-pointer {
        cursor: pointer;
    }

    .chevron-back {
        position: relative;
        &::after {
            position: absolute;
            right: 20px;
            font-family: "Font Awesome 5 Free";
            font-weight: 800;
            content: '\f078';
            display: inline-block;
        }
    
        &.up::after {
            content: '\f077';
        }
    }

    .vmw__special__search {
        background: $prim;
    }

    .sec-back {
        background: $sec;
        height: 40px;
    }

    .border-bottom {
        border-color: rgba(255,255,255,0.2) !important;
        &:last-of-type {
            border-bottom: 0 !important;
        
        }
    }

    .has-border-radius {
        border-radius: 0.25rem
    }

    button {
        height: 40px;
    }

    .filter-category, .filter-land, .filter-price {
        display: none;
        padding: 10px;
        width: 100%;
        top: 45px;
        background: $sec;
        z-index: 3;
        list-style-type: none;
        position: absolute;
        text-align: left;
        -webkit-transition: box-shadow 0.3s;
        -moz-transition: box-shadow 0.3s;
        -ms-transition: box-shadow 0.3s;
        -o-transition: box-shadow 0.3s;
        transition: box-shadow 0.3s;
        &.active {
            display: block;
            -webkit-box-shadow: 0px 5px 5px 5px rgba(117, 56, 56, 0.2);
            -moz-box-shadow: 0px 5px 5px 5px rgba(117, 56, 56, 0.2);
            box-shadow: 0px 5px 5px 5px rgba(117, 56, 56, 0.2);
        }
    }

    .hover-me-timbers {
        transition: all 0.3s;
        &:hover {
            color: var(--primary);
            transition: all 0.3s;
        }
    }
</style>
