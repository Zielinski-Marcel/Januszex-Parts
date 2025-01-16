import SecondaryButton from "@/Components/SecondaryButton.jsx";
import DangerButton from "@/Components/DangerButton.jsx";
import Modal from "@/Components/Modal.jsx";

export default function MessageBox({show, onClose, onAccept, title, children, acceptButtonText, isProcessing}) {
    return (
        <Modal show={show} onClose={onClose}>
            <div className="p-6">
                <h2 className="text-lg font-medium text-gray-900">
                    {title}
                </h2>

                <p className="mt-1 text-sm text-gray-600">
                    {children}
                </p>

                <div className="mt-6 flex justify-end">
                    <SecondaryButton onClick={onClose}>
                        Cancel
                    </SecondaryButton>

                    <DangerButton className="ms-3" disabled={isProcessing} onClick={onAccept}>
                        {acceptButtonText}
                    </DangerButton>
                </div>
            </div>
        </Modal>

    );
}
