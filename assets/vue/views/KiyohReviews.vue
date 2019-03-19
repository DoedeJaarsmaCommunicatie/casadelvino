<template lang="pug">
    article.kiyoh(v-if="loaded")
        section.topper
            aside.score
                kiyoh-circle-component(:grade="totalScore")
            aside.sidebar.text-right {{ totalReviews }} Beoordelingen
        section.review {{ latestReview }}
        a.kiyoh_button(:href="siteUrl", target="_blank", rel="noopener") Kiyoh
</template>

<script lang="ts">
// @ts-ignore
import KiyohCircleComponent from '../components/Kiyoh/KiyohCircleComponent';

export default {
  name: 'KiyohReviews',
  data() {
    return {
      loaded: false,
      totalScore: null,
      totalReviews: null,
      siteUrl: null,
      latestReview: null,
    }
  },
  components: {
  	KiyohCircleComponent
  },
  props: {
    fetchUrl: {
      type: String,
      default: 'wp-admin/admin-ajax.php?action=fetch_kiyoh'
    }
  },
  mounted() {
    this.$http
      .get(this.fetchUrl)
      .then((res) => {
        if (res.data.data) {
          this.loaded = true;
          const data = res.data.data;
          this.totalScore = data.total_score;
          this.totalReviews = data.total_reviews;
          this.siteUrl = data.kiyoh_url;
          this.latestReview = data.reviews.pro;
        }
      })
        .catch(e => {
			console.warn(e)
        })
  }
};
</script>

<style scoped lang="sass">
$p: 10px
$prim: #333
$mb: 0.5rem

.kiyoh
    padding: $p
    
.topper
    margin-bottom: 0.5rem

.review
    @extend .kiyoh
    $color: rgba($prim, 0.5)
    position: relative
    display: block
    border: 1px solid $color
    border-radius: 12px
    color: $color
    margin-bottom: 0.5rem
    height: 8rem
    overflow: hidden

.kiyoh_button
    background: $prim
    display: block
    text-align: center
    padding: 3px
    font-size: 1.5rem
    color: #fff
    
.topper
    display: grid
    grid-template-columns: 20% 80%
    grid-template-rows: 1fr
</style>
