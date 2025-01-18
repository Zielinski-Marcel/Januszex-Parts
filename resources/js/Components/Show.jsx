export default function Show({when, children}) {
    if(when) {
        return children;
    }

    return null;
}
