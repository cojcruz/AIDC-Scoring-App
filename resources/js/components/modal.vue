<template>
 	<transition name="modal">
 		<div class="modal-mask">
 			<div class="modal-wrapper">
 				<div class="modal-container">
 					<div class="modal-header">
 						<slot name="header">
 							default header
 						</slot>

 						<a class="modal-close" href="#" @click="$emit('close')" title="Close Modal">x</a>
 					</div>

 					<div class="modal-body">
 						<slot name="body">
 							default body
 						</slot>
 					</div>

 					<div class="modal-footer">
 						<slot name="footer">
 							default footer

 							<button class="modal-default-button" @click="$emit('close')">OK</button>
 						</slot>
 					</div>
 				</div>
 			</div>
 		</div>
 	</transition>
</template>

<script>
export default {
	date() {
		return {
			showModal: false
		}
	}
}
</script>