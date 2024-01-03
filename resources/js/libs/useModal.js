import Modal from "@/Pages/Components/Modal.vue";

export default  function useModal({modalRef}){
    const openModal = ({content, event}) => {
        modalRef.value.open = true
        modalRef.value.content = content
        modalRef.value.event = event;
    }

    return {
        openModal
    }
}
