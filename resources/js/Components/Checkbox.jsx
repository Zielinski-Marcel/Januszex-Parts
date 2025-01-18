export default function Checkbox({ className = '', ...props }) {
    return (
        <input
            {...props}
            type="checkbox"
            className={
                'rounded text-primary shadow-sm focus:ring-primary focus:ring-opacity-0'
            }
        />
    );
}
