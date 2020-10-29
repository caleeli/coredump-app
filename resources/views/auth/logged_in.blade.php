<script>
if (window.opener) {
  window.opener.postMessage(@json($response), '*');
  window.close();
} else {
  window.location.href = @json($redirectTo);
}
</script>