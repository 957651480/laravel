<template>
  <excavator-detail :is-edit="false" />
</template>

<script>
    import ExcavatorDetail from './components/ExcavatorDetail'

    export default {
  name: 'CreateArticle',
  components: { ExcavatorDetail }
}
</script>

