<template>
    <div class="vmw__special__search has-border-radius">
        <form class="text-center text-white font-weight-bold d-flex flex-column p-2" v-on:submit.prevent="submitData">
            <p class="m-0 mb-1">
                Ik ben op zoek naar:
            </p>
            
            <span class="sec-back has-border-radius my-1 d-flex justify-content-center align-items-center px-3 chevron-back position-relative cursor-pointer" v-on:click="changeCategoryOpen" v-on:blur="changeCategoryOpen">
                <label for="product-category" class="p-0 m-0 w-25 cursor-pointer">een</label> <span data-target="product-category">{{ categories['rode-wijn'] }}</span>
                <input type="hidden" disabled name="product-category" id="product-category" value="rode-wijn">
                <ul class="filter-category pt-0 pb-0 has-border-radius">
                    <li v-for="(category, key) in categories" :key="key" :data-category="key" v-on:click="selectCategory" class="p-1 border-bottom">{{category}}</li>
                </ul>
            </span>
            
            <span class="sec-back has-border-radius mt-1 mb-2 d-flex justify-content-center align-items-center px-3 position-relative cursor-pointer chevron-back" v-on:click="changePrijsOpen">
                <label for="product-price" class="p-0 m-0 w-25 cursor-pointer">voor</label> <span data-target="product-price">{{ prijzen[0].name }}</span>
                <input type="hidden" name="product-price" id="product-price" value="">
                <ul class="filter-price pt-0 pb-0 has-border-radius">
                    <li v-for="(prijs, index) in prijzen" :key="index" :data-price="prijs.key" v-on:click="selectPrijs" v-html="prijs.name" class="p-1 border-bottom">{{ index }}</li>
                </ul>
            </span>

            <button type="submit" class="btn bg-white text-dark has-border-radius">Toon resultaat</button>
        </form>
    </div>
</template>

<script>
    export default {
        mounted() {
        },
        data() {
            return {
                categories: {
                    'rood': 'Rode wijn',
                    'wit': 'Witte wijn',
                    'rose': 'Rose wijn',
                    'dessert': 'Dessert wijn',
                    'mousserende': 'Mousserende wijn'
                },
                prijzen: [
                    {
                        key: '',
                        name: 'alle prijzen',
                    },
                    {
                        key: '5-5',
                        name: '&euro; 5'
                    },
                    {
                        key: '5-15',
                        name: '&euro; 5 - &euro; 15'
                    },
                    {
                        key: '15-25',
                        name: '&euro; 15 - &euro; 25',
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
                default: 'https://casadelvino.nl/winkel/'
            }
        },
        methods: {
            submitData: function() {
                let prijs = document.querySelector('#product-price').value;
                let category = document.querySelector('#product-category').value;
                let params = new URLSearchParams();

                params.append('product-category', category);
                if( prijs !== '' ) {
					params.append('product-price', prijs)
                }

                let pUrl = `${this.url}?${params.toString()}`;
                window.location.href = pUrl
            },
            changeCategoryOpen: function (event) {
                event.target.classList.toggle('up');
                document.querySelector('.filter-category').classList.toggle('active')
            },
            changeLandOpen: function (event) {
                event.target.classList.toggle('up');
                document.querySelector('.filter-land').classList.toggle('active')
            },
            changePrijsOpen: function (event) {
                event.target.classList.toggle('up');
                document.querySelector('.filter-price').classList.toggle('active')
            },
            selectCategory: function(ev) {
                let k = ev.target.dataset.category;
                document.querySelector('input#product-category').value = k;
                document.querySelector('[data-target="product-category"]').innerHTML = this.categories[k];
                this.allChevronDown();
            },
            selectland: function (ev) {
                let k = ev.target.dataset.land;
                document.querySelector('input#product-land').value = k;
                document.querySelector('[data-target="product-land"]').innerHTML = this.landen[k];
                this.allChevronDown();
            },
            selectPrijs: function (ev) {
                let k = event.target.dataset.price;
                document.querySelector('input#product-price').value = k;
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
                document.querySelector('.filter-land').classList.remove('active');
                document.querySelector('.filter-price').classList.remove('active')
            }
        },
    }
</script>

<style lang="scss" scoped>
    @import "https://use.fontawesome.com/releases/v5.6.3/css/all.css";
    $prim: #69796B;
    $sec: #445846;
    
    * {
        font-family: "Open Sans";
        font-weight: 300;
    }
    select {
        border:none;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        -ms-appearance: none; /* get rid of default appearance for IE8, 9 and 10*/
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
</style>
