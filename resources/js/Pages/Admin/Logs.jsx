import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.jsx";
import { Link } from "@inertiajs/react";
import React from "react";

export default function Logs({ logs }) {
    // Helper function to format date
    const formatDate = (dateString) => {
        const options = {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        };
        return new Intl.DateTimeFormat('en-US', options).format(new Date(dateString));
    };

    // Sort logs by updated_at descending, then reverse for newest first
    const sortedLogs = [...logs].sort((a, b) => new Date(b.updated_at) - new Date(a.updated_at));

    return (
        <AuthenticatedLayout>
            <div className="py-12">
                <div className="mx-auto max-w-3xl space-y-6 sm:px-6 lg:px-8">
                    <div className="bg-white p-4 shadow sm:rounded-lg sm:p-8 space-y-4">
                        <div>
                            <div className="flex flex-col gap-4">
                                <h2 className="text-lg font-medium text-gray-900">List of Logs</h2>
                                {sortedLogs.map((log) => (
                                    <div key={log.id} className="space-y-4">
                                        <div className="bg-white rounded-lg border border-gray-100 min-w-full">
                                            <div className="p-4">
                                                <div className="flex items-start justify-between mb-2">
                                                    <div className="flex-1">
                                                        <div className="flex items-center gap-4 mb-1">
                                                            <span className="font-medium">
                                                                User id: {log.causer_id}
                                                            </span>
                                                        </div>
                                                        <p className="text-sm text-gray-500 leading-relaxed">
                                                            Description: {log.description}
                                                        </p>
                                                        <p className="text-sm text-gray-500 leading-relaxed">
                                                            At: {formatDate(log.updated_at)}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
