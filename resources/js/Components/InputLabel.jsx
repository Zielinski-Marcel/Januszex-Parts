export default function InputLabel({
    value,
    className = '',
    children,
    ...props
}) {
    return (
        <label
            {...props}
            className={
                `block text-sm font-medium text-gray-700 focus:ring-primary` +
                className
            }
        >
            {value ? value : children}
        </label>
    );
}
