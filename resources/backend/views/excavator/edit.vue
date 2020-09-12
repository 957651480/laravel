<template>
  <excavator-detail :is-edit="true" />
</template>

<script>
  import ExcavatorDetail from './components/ExcavatorDetail'

  export default {
  name: 'EditForm',
  components: { ExcavatorDetail }
}
</script>

