import React, { useState, useEffect } from 'react';
import { createRoot } from 'react-dom/client';
import axios from 'axios';

// Slide-down Notification Component
const SlideDownNotification = ({ message, type, onClose, isVisible }) => {
    useEffect(() => {
        if (isVisible) {
            const timer = setTimeout(() => {
                onClose();
            }, 3000);
            return () => clearTimeout(timer);
        }
    }, [isVisible, onClose]);

    if (!isVisible) return null;

    const bgColor = type === 'success' ? 'bg-success' : type === 'error' ? 'bg-danger' : 'bg-info';

    return (
        <div
            className={`position-fixed top-0 start-0 end-0 ${bgColor} text-white py-3 px-4 shadow-lg`}
            style={{
                zIndex: 9999,
                transform: isVisible ? 'translateY(0)' : 'translateY(-100%)',
                transition: 'transform 0.3s ease-in-out',
            }}
        >
            <div className="container-fluid d-flex justify-content-between align-items-center">
                <span className="fw-bold">{message}</span>
                <button
                    onClick={onClose}
                    className="btn btn-sm btn-outline-light border-0"
                    style={{ fontSize: '1.2rem', lineHeight: 1 }}
                >
                    &times;
                </button>
            </div>
        </div>
    );
};

const AdminDashboard = () => {
    const [entries, setEntries] = useState([]);
    const [activeEntry, setActiveEntry] = useState(null);
    const [loading, setLoading] = useState(true);
    const [searchCode, setSearchCode] = useState('');
    const [foundEntry, setFoundEntry] = useState(null);
    const [csrfToken, setCsrfToken] = useState('');
    const [notification, setNotification] = useState({ message: '', type: 'success', isVisible: false });

    useEffect(() => {
        // Get CSRF token from meta tag
        const token = document.querySelector('meta[name="csrf-token"]')?.content;
        setCsrfToken(token);

        // Set up axios defaults
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        if (token) {
            axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
        }

        fetchEntries();
    }, []);

    const showNotification = (message, type = 'success') => {
        setNotification({ message, type, isVisible: true });
    };

    const hideNotification = () => {
        setNotification(prev => ({ ...prev, isVisible: false }));
    };

    const fetchEntries = async () => {
        try {
            const response = await axios.get('/api/admin/entries');
            setEntries(response.data.entries);
            setActiveEntry(response.data.activeEntry);
            setLoading(false);
        } catch (error) {
            console.error('Error fetching entries:', error);
            showNotification('Error loading entries', 'error');
            setLoading(false);
        }
    };

    // Filter entries: if active entry exists, only show same category entries
    const filteredEntries = activeEntry && activeEntry.category
        ? entries.filter(e => e.category === activeEntry.category)
        : entries;

    const handleActivate = async (code) => {
        try {
            await axios.get(`/dashboard/admin/activate/${code}`);
            await fetchEntries();
            showNotification(`Entry ${code} Activated!`, 'success');
        } catch (error) {
            console.error('Error activating entry:', error);
            showNotification('Failed to activate entry', 'error');
        }
    };

    const handleDeactivate = async (code) => {
        try {
            await axios.get(`/dashboard/admin/clear/${code}`);
            await fetchEntries();
            showNotification(`Entry ${code} Deactivated!`, 'success');
        } catch (error) {
            console.error('Error deactivating entry:', error);
            showNotification('Failed to deactivate entry', 'error');
        }
    };

    const handleClearActive = async () => {
        try {
            await axios.post('/dashboard/admin/clear', { _token: csrfToken });
            await fetchEntries();
            showNotification('Active entry cleared!', 'success');
        } catch (error) {
            console.error('Error clearing active entry:', error);
            showNotification('Failed to clear active entry', 'error');
        }
    };

    const handleFindEntry = () => {
        const entry = entries.find(e => e.code.toLowerCase() === searchCode.toLowerCase());
        if (entry) {
            setFoundEntry(entry);
            showNotification(`Found: ${entry.code} - ${entry.entry_name}`, 'success');
        } else {
            setFoundEntry(null);
            showNotification('Entry not found', 'error');
        }
    };

    const handleSetActive = async () => {
        if (!searchCode) {
            showNotification('Please enter a participant number', 'error');
            return;
        }
        try {
            await axios.post('/dashboard/admin/activate', {
                _token: csrfToken,
                code: searchCode
            });
            await fetchEntries();
            setSearchCode('');
            showNotification('Entry Activated!', 'success');
        } catch (error) {
            console.error('Error activating entry:', error);
            showNotification('Failed to activate entry', 'error');
        }
    };

    if (loading) {
        return <div className="text-center py-4">Loading entries...</div>;
    }

    return (
        <div className="admin-dashboard">
            <SlideDownNotification
                message={notification.message}
                type={notification.type}
                isVisible={notification.isVisible}
                onClose={hideNotification}
            />
            {/* Control Panel */}
            <div className="row justify-content-center mb-4">
                <div className="col-md-4">
                    <div className="card">
                        <div className="card-header">Find Entry</div>
                        <div className="card-body">
                            <input
                                type="text"
                                className="form-control mb-2"
                                placeholder="Enter code"
                                value={searchCode}
                                onChange={(e) => setSearchCode(e.target.value)}
                                onKeyPress={(e) => e.key === 'Enter' && handleFindEntry()}
                            />
                            <button className="btn btn-primary w-100" onClick={handleFindEntry}>
                                Find
                            </button>
                            {foundEntry && (
                                <div className="mt-2 p-2 bg-light rounded">
                                    <strong>{foundEntry.code}</strong> - {foundEntry.entry_name}
                                    <br />
                                    <small>{foundEntry.entry_school} | {foundEntry.category}</small>
                                </div>
                            )}
                        </div>
                    </div>
                </div>
                <div className="col-md-4">
                    <div className="card">
                        <div className="card-header">Set Active Entry</div>
                        <div className="card-body">
                            <input
                                type="text"
                                className="form-control mb-2"
                                placeholder="Enter Participant Number"
                                value={searchCode}
                                onChange={(e) => setSearchCode(e.target.value)}
                                onKeyPress={(e) => e.key === 'Enter' && handleSetActive()}
                            />
                            <button className="btn btn-primary w-100" onClick={handleSetActive}>
                                Submit
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {/* Active Entry Status */}
            <div className="row justify-content-center mb-4">
                <div className="col-md-4">
                    <div className="card">
                        <div className="card-header">Clear Active Entry</div>
                        <div className="card-body text-center">
                            <button className="btn btn-warning" onClick={handleClearActive}>
                                Clear
                            </button>
                        </div>
                    </div>
                </div>
                <div className="col-md-4">
                    <div className="card">
                        <div className="card-header">Current Active Entry</div>
                        <div className="card-body text-center">
                            <input
                                type="text"
                                className="form-control text-center"
                                readOnly
                                value={activeEntry?.code || 'No Active Entry'}
                            />
                        </div>
                    </div>
                </div>
            </div>

            {/* Live Scoring and Ranking Links */}
            <div className="row justify-content-center mb-4">
                <div className="col-md-4">
                    <div className="card">
                        <div className="card-header">Live Scoring Page</div>
                        <div className="card-body text-center">
                            <a
                                href="/dashboard/livescoring"
                                className="btn btn-primary"
                                target="LiveScoring"
                                rel="noopener noreferrer"
                            >
                                Launch
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {/* Entries Table */}
            <div className="card">
                <div className="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5 className="mb-0">
                            {activeEntry && activeEntry.category ? (
                                <>
                                    Entries - <span className="text-info">{activeEntry.category}</span> Category
                                </>
                            ) : (
                                'All Entries'
                            )}
                        </h5>
                        {activeEntry && activeEntry.category && (
                            <small className="text-muted">
                                Showing entries with same category as active entry ({activeEntry.code})
                            </small>
                        )}
                    </div>
                    <span className="badge bg-primary">{filteredEntries.length} entries</span>
                </div>
                <div className="card-body p-0">
                    <div className="table-responsive" style={{ maxHeight: '500px', overflow: 'auto' }}>
                        <table className="table table-striped table-hover mb-0">
                            <thead className="sticky-top bg-white">
                                <tr>
                                    <th>Status</th>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Age</th>
                                    <th>School</th>
                                    <th>Category</th>
                                    <th>Scores</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                {filteredEntries.map((entry) => (
                                    <tr key={entry.id}>
                                        <td>
                                            {activeEntry?.code === entry.code ? (
                                                <span className="badge bg-success">Active</span>
                                            ) : (
                                                <span className="badge bg-secondary">-</span>
                                            )}
                                        </td>
                                        <td>
                                            <strong>{entry.code}</strong>
                                        </td>
                                        <td>{entry.entry_name}</td>
                                        <td>{entry.age ? Math.round(entry.age * 100) / 100 : '-'}</td>
                                        <td>{entry.entry_school}</td>
                                        <td>{entry.category}</td>
                                        <td>
                                            <div className="d-flex gap-2 text-center">
                                                <div>
                                                    <div className="fw-bold">{entry.judge_a || '-'}</div>
                                                    <small className="text-muted">A</small>
                                                </div>
                                                <div>
                                                    <div className="fw-bold">{entry.judge_b || '-'}</div>
                                                    <small className="text-muted">B</small>
                                                </div>
                                                <div>
                                                    <div className="fw-bold">{entry.judge_c || '-'}</div>
                                                    <small className="text-muted">C</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            {activeEntry?.code === entry.code ? (
                                                <button
                                                    className="btn btn-sm btn-secondary"
                                                    onClick={() => handleDeactivate(entry.code)}
                                                >
                                                    Deactivate
                                                </button>
                                            ) : (
                                                <button
                                                    className="btn btn-sm btn-primary"
                                                    onClick={() => handleActivate(entry.code)}
                                                >
                                                    Activate
                                                </button>
                                            )}
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    );
};

// Mount the React component
const container = document.getElementById('admin-react-root');
if (container) {
    const root = createRoot(container);
    root.render(<AdminDashboard />);
}

export default AdminDashboard;
