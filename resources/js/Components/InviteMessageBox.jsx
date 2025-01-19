import SecondaryButton from "@/Components/SecondaryButton.jsx";
import DangerButton from "@/Components/DangerButton.jsx";
import Modal from "@/Components/Modal.jsx";
import TextInput from "@/Components/TextInput.jsx";
import PrimaryButton from "@/Components/PrimaryButton.jsx";
import InputError from "@/Components/InputError.jsx";

export default function InviteMessageBox({show, onClose, onAccept, onChange, isProcessing, error}) {
    return (
        <Modal show={show} onClose={onClose}>
            <div className="p-6">
                <h2 className="text-lg font-medium text-gray-900">
                    Enter your friends E-mail address
                </h2>

                <p className="mt-1 text-sm text-gray-600 w-full pt-3">
                    <TextInput type="email" placeholder="E-mail" onChange={onChange}
                               className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-primary"
                    ></TextInput>
                    <InputError message={error} className="mt-1" />
                </p>

                <div className="mt-6 flex justify-end">
                    <SecondaryButton onClick={onClose}>
                        Cancel
                    </SecondaryButton>

                    <PrimaryButton className="ms-3" disabled={isProcessing} onClick={onAccept}>
                        Send
                    </PrimaryButton>
                </div>
            </div>
        </Modal>

    );
}
