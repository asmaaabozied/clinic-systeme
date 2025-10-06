import React, { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";

const Navdata = () => {
    const history = useNavigate();
    //state data
    const [isDashboard, setIsDashboard] = useState(false);
    const [isApps, setIsApps] = useState(false);
    const [isAuth, setIsAuth] = useState(false);
    const [isPages, setIsPages] = useState(false);
    const [isBaseUi, setIsBaseUi] = useState(false);
    const [isAdvanceUi, setIsAdvanceUi] = useState(false);
    const [isForms, setIsForms] = useState(false);
    const [isTables, setIsTables] = useState(false);
    const [isCharts, setIsCharts] = useState(false);
    const [isIcons, setIsIcons] = useState(false);
    const [isMaps, setIsMaps] = useState(false);
    const [isMultiLevel, setIsMultiLevel] = useState(false);

    // Add state for Reports
    //Calender
    const [isCalender, setCalender] = useState(false);

    // Apps
    const [isEmail, setEmail] = useState(false);
    const [isSubEmail, setSubEmail] = useState(false);
    const [isEcommerce, setIsEcommerce] = useState(false);
    const [isProjects, setIsProjects] = useState(false);
    const [isTasks, setIsTasks] = useState(false);
    const [isCRM, setIsCRM] = useState(false);
    const [isCrypto, setIsCrypto] = useState(false);
    const [isInvoices, setIsInvoices] = useState(false);
    const [isSupportTickets, setIsSupportTickets] = useState(false);
    const [isNFTMarketplace, setIsNFTMarketplace] = useState(false);
    const [isLanding, setIsLanding] = useState(false);
    const [isJobs, setIsJobs] = useState(false);
    const [isJobList, setIsJobList] = useState(false);
    const [isCandidateList, setIsCandidateList] = useState(false);

    // Authentication
    const [isSignIn, setIsSignIn] = useState(false);
    const [isSignUp, setIsSignUp] = useState(false);
    const [isPasswordReset, setIsPasswordReset] = useState(false);
    const [isPasswordCreate, setIsPasswordCreate] = useState(false);
    const [isLockScreen, setIsLockScreen] = useState(false);
    const [isLogout, setIsLogout] = useState(false);
    const [isSuccessMessage, setIsSuccessMessage] = useState(false);
    const [isVerification, setIsVerification] = useState(false);
    const [isError, setIsError] = useState(false);

    // Pages
    const [isProfile, setIsProfile] = useState(false);
    const [isBlog, setIsBlog] = useState(false);

    // Charts
    const [isApex, setIsApex] = useState(false);

    // Multi Level
    const [isLevel1, setIsLevel1] = useState(false);
    const [isLevel2, setIsLevel2] = useState(false);

    // Add new DashboardV2 menu section and state variables (unique names)
    const [isDashboardV2, setIsDashboardV2] = useState(false);
    const [isDashboardV2Accounting, setIsDashboardV2Accounting] = useState(false);
    const [isDashboardV2AccountingReports, setIsDashboardV2AccountingReports] = useState(false);
    const [isDashboardV2HRM, setIsDashboardV2HRM] = useState(false);
    const [isDashboardV2CRM, setIsDashboardV2CRM] = useState(false);
    const [isDashboardV2POS, setIsDashboardV2POS] = useState(false);
    const [isDashboardV2POSReports, setIsDashboardV2POSReports] = useState(false);

    // Add new HRM System section and state variables (unique names)
    const [isHRMSystem, setIsHRMSystem] = useState(false);
    const [isHRMSystemEmployeeSetup, setIsHRMSystemEmployeeSetup] = useState(false);
    const [isHRMSystemPayrollSetup, setIsHRMSystemPayrollSetup] = useState(false);
    const [isHRMSystemLeaveManagementSetup, setIsHRMSystemLeaveManagementSetup] = useState(false);
    const [isHRMSystemAttendance, setIsHRMSystemAttendance] = useState(false);
    const [isHRMSystemPerformanceSetup, setIsHRMSystemPerformanceSetup] = useState(false);
    const [isHRMSystemTrainingSetup, setIsHRMSystemTrainingSetup] = useState(false);
    const [isHRMSystemRecruitmentSetup, setIsHRMSystemRecruitmentSetup] = useState(false);
    const [isHRMSystemJobCandidate, setIsHRMSystemJobCandidate] = useState(false);
    const [isHRMSystemHRAdminSetup, setIsHRMSystemHRAdminSetup] = useState(false);

    // Add new Medical Management section state variable
    const [isMedicalManagement, setIsMedicalManagement] = useState(false);

    const [iscurrentState, setIscurrentState] = useState('Dashboard');

    function updateIconSidebar(e) {
        if (e && e.target && e.target.getAttribute("subitems")) {
            const ul = document.getElementById("two-column-menu");
            const iconItems = ul.querySelectorAll(".nav-icon.active");
            let activeIconItems = [...iconItems];
            activeIconItems.forEach((item) => {
                item.classList.remove("active");
                var id = item.getAttribute("subitems");
                if (document.getElementById(id))
                    document.getElementById(id).classList.remove("show");
            });
        }
    }

    useEffect(() => {
        document.body.classList.remove('twocolumn-panel');
        if (iscurrentState !== 'Dashboard') {
            setIsDashboard(false);
        }
        if (iscurrentState !== 'Apps') {
            setIsApps(false);
        }
        if (iscurrentState !== 'Auth') {
            setIsAuth(false);
        }
        if (iscurrentState !== 'Pages') {
            setIsPages(false);
        }
        if (iscurrentState !== 'Landing') {
            setIsLanding(false);
        }
        if (iscurrentState !== 'BaseUi') {
            setIsBaseUi(false);
        }
        if (iscurrentState !== 'AdvanceUi') {
            setIsAdvanceUi(false);
        }
        if (iscurrentState !== 'Forms') {
            setIsForms(false);
        }
        if (iscurrentState !== 'Tables') {
            setIsTables(false);
        }
        if (iscurrentState !== 'Charts') {
            setIsCharts(false);
        }
        if (iscurrentState !== 'Icons') {
            setIsIcons(false);
        }
        if (iscurrentState !== 'Maps') {
            setIsMaps(false);
        }
        if (iscurrentState !== 'MuliLevel') {
            setIsMultiLevel(false);
        }
        // Add reset logic for new menus
        if (iscurrentState !== 'DashboardV2') {
            setIsDashboardV2(false);
        }
        if (iscurrentState !== 'HRMSystem') {
            setIsHRMSystem(false);
        }
        if (iscurrentState === 'Widgets') {
            history("/widgets");
            document.body.classList.add('twocolumn-panel');
        }
        if (iscurrentState !== 'MedicalManagement') {
            setIsMedicalManagement(false);
        }
    }, [
        history,
        iscurrentState,
        isDashboard,
        isApps,
        isAuth,
        isPages,
        isBaseUi,
        isAdvanceUi,
        isForms,
        isTables,
        isCharts,
        isIcons,
        isMaps,
        isMultiLevel,
        // Add new menu state variables to dependencies
        isDashboardV2,
        isHRMSystem,
        isMedicalManagement
    ]);

    const menuItems = [
        {
            label: "Menu",
            isHeader: true,
        },
        {
            id: "dashboard",
            label: "Dashboards",
            icon: "ri-dashboard-2-line",
            link: "/#",
            stateVariables: isDashboard,
            click: function (e) {
                e.preventDefault();
                setIsDashboard(!isDashboard);
                setIscurrentState('Dashboard');
                updateIconSidebar(e);
            },
            subItems: [
                {
                    id: "analytics",
                    label: "Analytics",
                    link: "/dashboard-analytics",
                    parentId: "dashboard",
                },
                {
                    id: "crm",
                    label: "CRM",
                    link: "/dashboard-crm",
                    parentId: "dashboard",
                },
                {
                    id: "ecommerce",
                    label: "Ecommerce",
                    link: "/dashboard",
                    parentId: "dashboard",
                },
                {
                    id: "crypto",
                    label: "Crypto",
                    link: "/dashboard-crypto",
                    parentId: "dashboard",
                },
                {
                    id: "projects",
                    label: "Projects",
                    link: "/dashboard-projects",
                    parentId: "dashboard",
                },
                {
                    id: "nft",
                    label: "NFT",
                    link: "/dashboard-nft",
                    parentId: "dashboard",
                },
                {
                    id: "job",
                    label: "Job",
                    link: "/dashboard-job",
                    parentId: "dashboard",
                },
                {
                    id: "blog",
                    label: "Blog",
                    link: "/dashboard-blog",
                    parentId: "dashboard",
                    badgeColor: "success",
                    badgeName: "New",
                },
            ],
        },
        {
            id: "apps",
            label: "Apps",
            icon: "ri-apps-2-line",
            link: "/#",
            click: function (e) {
                e.preventDefault();
                setIsApps(!isApps);
                setIscurrentState('Apps');
                updateIconSidebar(e);
            },
            stateVariables: isApps,
            subItems: [
                {
                    id: "calendar",
                    label: "Calendar",
                    link: "/#",
                    parentId: "apps",
                    isChildItem: true,
                    click: function (e) {
                        e.preventDefault();
                        setCalender(!isCalender);
                    },
                    stateVariables: isCalender,
                    childItems: [
                        {
                            id: 1,
                            label: "Main Calender",
                            link: "/apps-calendar",
                            parentId: "apps"
                        },
                        {
                            id: 2,
                            label: "Month Grid",
                            link: "/apps-calendar-month-grid",
                            parentId: "apps",
                        },
                    ]
                },
                {
                    id: "chat",
                    label: "Chat",
                    link: "/apps-chat",
                    parentId: "apps",
                },
                {
                    id: "mailbox",
                    label: "Email",
                    link: "/#",
                    parentId: "apps",
                    isChildItem: true,
                    click: function (e) {
                        e.preventDefault();
                        setEmail(!isEmail);
                    },
                    stateVariables: isEmail,
                    childItems: [
                        {
                            id: 1,
                            label: "Mailbox",
                            link: "/apps-mailbox",
                            parentId: "apps"
                        },
                        {
                            id: 2,
                            label: "Email Templates",
                            link: "/#",
                            parentId: "apps",
                            isChildItem: true,
                            stateVariables: isSubEmail,
                            click: function (e) {
                                e.preventDefault();
                                setSubEmail(!isSubEmail);
                            },
                            childItems: [
                                { id: 2, label: "Basic Action", link: "/apps-email-basic", parentId: "apps" },
                                { id: 3, label: "Ecommerce Action", link: "/apps-email-ecommerce", parentId: "apps" },
                            ],
                        },
                    ]
                },
                {
                    id: "appsecommerce",
                    label: "Ecommerce",
                    link: "/#",
                    isChildItem: true,
                    click: function (e) {
                        e.preventDefault();
                        setIsEcommerce(!isEcommerce);
                    },
                    parentId: "apps",
                    stateVariables: isEcommerce,
                    childItems: [
                        { id: 1, label: "Products", link: "/apps-ecommerce-products", parentId: "apps" },
                        { id: 2, label: "Product Details", link: "/apps-ecommerce-product-details", parentId: "apps" },
                        { id: 3, label: "Create Product", link: "/apps-ecommerce-add-product", parentId: "apps" },
                        { id: 4, label: "Orders", link: "/apps-ecommerce-orders", parentId: "apps" },
                        { id: 5, label: "Order Details", link: "/apps-ecommerce-order-details", parentId: "apps" },
                        { id: 6, label: "Customers", link: "/apps-ecommerce-customers", parentId: "apps" },
                        { id: 7, label: "Shopping Cart", link: "/apps-ecommerce-cart", parentId: "apps" },
                        { id: 8, label: "Checkout", link: "/apps-ecommerce-checkout", parentId: "apps" },
                        { id: 9, label: "Sellers", link: "/apps-ecommerce-sellers", parentId: "apps" },
                        { id: 10, label: "Seller Details", link: "/apps-ecommerce-seller-details", parentId: "apps" },
                    ]
                },
                {
                    id: "appsprojects",
                    label: "Projects",
                    link: "/#",
                    isChildItem: true,
                    click: function (e) {
                        e.preventDefault();
                        setIsProjects(!isProjects);
                    },
                    parentId: "apps",
                    stateVariables: isProjects,
                    childItems: [
                        { id: 1, label: "List", link: "/apps-projects-list", parentId: "apps", },
                        { id: 2, label: "Overview", link: "/apps-projects-overview", parentId: "apps", },
                        { id: 3, label: "Create Project", link: "/apps-projects-create", parentId: "apps", },
                    ]
                },
                {
                    id: "tasks",
                    label: "Tasks",
                    link: "/#",
                    isChildItem: true,
                    click: function (e) {
                        e.preventDefault();
                        setIsTasks(!isTasks);
                    },
                    parentId: "apps",
                    stateVariables: isTasks,
                    childItems: [
                        { id: 1, label: "Kanban Board", link: "/apps-tasks-kanban", parentId: "apps", },
                        { id: 2, label: "List View", link: "/apps-tasks-list-view", parentId: "apps", },
                        { id: 3, label: "Task Details", link: "/apps-tasks-details", parentId: "apps", },
                    ]
                },
                {
                    id: "appscrm",
                    label: "CRM",
                    link: "/#",
                    isChildItem: true,
                    click: function (e) {
                        e.preventDefault();
                        setIsCRM(!isCRM);
                    },
                    parentId: "apps",
                    stateVariables: isCRM,
                    childItems: [
                        { id: 1, label: "Contacts", link: "/apps-crm-contacts" },
                        { id: 2, label: "Companies", link: "/apps-crm-companies" },
                        { id: 3, label: "Deals", link: "/apps-crm-deals" },
                        { id: 4, label: "Leads", link: "/apps-crm-leads" },
                    ]
                },
                {
                    id: "appscrypto",
                    label: "Crypto",
                    link: "/#",
                    isChildItem: true,
                    click: function (e) {
                        e.preventDefault();
                        setIsCrypto(!isCrypto);
                    },
                    parentId: "apps",
                    stateVariables: isCrypto,
                    childItems: [
                        { id: 1, label: "Transactions", link: "/apps-crypto-transactions" },
                        { id: 2, label: "Buy & Sell", link: "/apps-crypto-buy-sell" },
                        { id: 3, label: "Orders", link: "/apps-crypto-orders" },
                        { id: 4, label: "My Wallet", link: "/apps-crypto-wallet" },
                        { id: 5, label: "ICO List", link: "/apps-crypto-ico" },
                        { id: 6, label: "KYC Application", link: "/apps-crypto-kyc" },
                    ]
                },
                {
                    id: "invoices",
                    label: "Invoices",
                    link: "/#",
                    isChildItem: true,
                    click: function (e) {
                        e.preventDefault();
                        setIsInvoices(!isInvoices);
                    },
                    parentId: "apps",
                    stateVariables: isInvoices,
                    childItems: [
                        { id: 1, label: "List View", link: "/apps-invoices-list" },
                        { id: 2, label: "Details", link: "/apps-invoices-details" },
                        { id: 3, label: "Create Invoice", link: "/apps-invoices-create" },
                    ]
                },
                {
                    id: "supportTickets",
                    label: "Support Tickets",
                    link: "/#",
                    isChildItem: true,
                    click: function (e) {
                        e.preventDefault();
                        setIsSupportTickets(!isSupportTickets);
                    },
                    parentId: "apps",
                    stateVariables: isSupportTickets,
                    childItems: [
                        { id: 1, label: "List View", link: "/apps-tickets-list" },
                        { id: 2, label: "Ticket Details", link: "/apps-tickets-details" },
                    ]
                },
                {
                    id: "NFTMarketplace",
                    label: "NFT Marketplace",
                    link: "/#",
                    isChildItem: true,
                    click: function (e) {
                        e.preventDefault();
                        setIsNFTMarketplace(!isNFTMarketplace);
                    },
                    parentId: "apps",
                    stateVariables: isNFTMarketplace,
                    childItems: [
                        { id: 1, label: "Marketplace", link: "/apps-nft-marketplace" },
                        { id: 2, label: "Explore Now", link: "/apps-nft-explore" },
                        { id: 3, label: "Live Auction", link: "/apps-nft-auction" },
                        { id: 4, label: "Item Details", link: "/apps-nft-item-details" },
                        { id: 5, label: "Collections", link: "/apps-nft-collections" },
                        { id: 6, label: "Creators", link: "/apps-nft-creators" },
                        { id: 7, label: "Ranking", link: "/apps-nft-ranking" },
                        { id: 8, label: "Wallet Connect", link: "/apps-nft-wallet" },
                        { id: 9, label: "Create NFT", link: "/apps-nft-create" },
                    ]
                },
                {
                    id: "filemanager",
                    label: "File Manager",
                    link: "/apps-file-manager",
                    parentId: "apps",
                },
                {
                    id: "todo",
                    label: "To Do",
                    link: "/apps-todo",
                    parentId: "apps",
                },
                {
                    id: "job",
                    label: "Jobs",
                    link: "/#",
                    parentId: "apps",
                    isChildItem: true,
                    click: function (e) {
                        e.preventDefault();
                        setIsJobs(!isJobs);
                    },
                    stateVariables: isJobs,
                    childItems: [
                        {
                            id: 1,
                            label: "Statistics",
                            link: "/apps-job-statistics",
                            parentId: "apps",
                        },
                        {
                            id: 2,
                            label: "Job Lists",
                            link: "/#",
                            parentId: "apps",
                            isChildItem: true,
                            stateVariables: isJobList,
                            click: function (e) {
                                e.preventDefault();
                                setIsJobList(!isJobList);
                            },
                            childItems: [
                                {
                                    id: 1,
                                    label: "List",
                                    link: "/apps-job-lists",
                                    parentId: "apps",
                                },
                                {
                                    id: 2,
                                    label: "Grid",
                                    link: "/apps-job-grid-lists",
                                    parentId: "apps",
                                },
                                {
                                    id: 3,
                                    label: "Overview",
                                    link: "/apps-job-details",
                                    parentId: "apps",
                                },
                            ],
                        },
                        {
                            id: 3,
                            label: "Candidate Lists",
                            link: "/#",
                            parentId: "apps",
                            isChildItem: true,
                            stateVariables: isCandidateList,
                            click: function (e) {
                                e.preventDefault();
                                setIsCandidateList(!isCandidateList);
                            },
                            childItems: [
                                {
                                    id: 1,
                                    label: "List View",
                                    link: "/apps-job-candidate-lists",
                                    parentId: "apps",
                                },
                                {
                                    id: 2,
                                    label: "Grid View",
                                    link: "/apps-job-candidate-grid",
                                    parentId: "apps",
                                },
                            ],
                        },
                        {
                            id: 4,
                            label: "Application",
                            link: "/apps-job-application",
                            parentId: "apps",
                        },
                        {
                            id: 5,
                            label: "New Job",
                            link: "/apps-job-new",
                            parentId: "apps",
                        },
                        {
                            id: 6,
                            label: "Companies List",
                            link: "/apps-job-companies-lists",
                            parentId: "apps",
                        },
                        {
                            id: 7,
                            label: "Job Categories",
                            link: "/apps-job-categories",
                            parentId: "apps",
                        },
                    ],
                },
                {
                    id: "apikey",
                    label: "API Key",
                    link: "/apps-api-key",
                    parentId: "apps",
                },
            ],
        },
        {
            label: "Pages",
            isHeader: true,
        },
        {
            id: "authentication",
            label: "Authentication",
            icon: "ri-account-circle-line",
            link: "/#",
            click: function (e) {
                e.preventDefault();
                setIsAuth(!isAuth);
                setIscurrentState('Auth');
                updateIconSidebar(e);
            },
            stateVariables: isAuth,
            subItems: [
                {
                    id: "signIn",
                    label: "Sign In",
                    link: "/#",
                    isChildItem: true,
                    click: function (e) {
                        e.preventDefault();
                        setIsSignIn(!isSignIn);
                    },
                    parentId: "authentication",
                    stateVariables: isSignIn,
                    childItems: [
                        { id: 1, label: "Basic", link: "/auth-signin-basic" },
                        { id: 2, label: "Cover", link: "/auth-signin-cover" },
                    ]
                },
                {
                    id: "signUp",
                    label: "Sign Up",
                    link: "/#",
                    isChildItem: true,
                    click: function (e) {
                        e.preventDefault();
                        setIsSignUp(!isSignUp);
                    },
                    parentId: "authentication",
                    stateVariables: isSignUp,
                    childItems: [
                        { id: 1, label: "Basic", link: "/auth-signup-basic" },
                        { id: 2, label: "Cover", link: "/auth-signup-cover" },
                    ]
                },
                {
                    id: "passwordReset",
                    label: "Password Reset",
                    link: "/#",
                    isChildItem: true,
                    click: function (e) {
                        e.preventDefault();
                        setIsPasswordReset(!isPasswordReset);
                    },
                    parentId: "authentication",
                    stateVariables: isPasswordReset,
                    childItems: [
                        { id: 1, label: "Basic", link: "/auth-pass-reset-basic" },
                        { id: 2, label: "Cover", link: "/auth-pass-reset-cover" },
                    ]
                },
                {
                    id: "passwordCreate",
                    label: "Password Create",
                    link: "/#",
                    isChildItem: true,
                    click: function (e) {
                        e.preventDefault();
                        setIsPasswordCreate(!isPasswordCreate);
                    },
                    parentId: "authentication",
                    stateVariables: isPasswordCreate,
                    childItems: [
                        { id: 1, label: "Basic", link: "/auth-pass-change-basic" },
                        { id: 2, label: "Cover", link: "/auth-pass-change-cover" },
                    ]
                },
                {
                    id: "lockScreen",
                    label: "Lock Screen",
                    link: "/#",
                    isChildItem: true,
                    click: function (e) {
                        e.preventDefault();
                        setIsLockScreen(!isLockScreen);
                    },
                    parentId: "authentication",
                    stateVariables: isLockScreen,
                    childItems: [
                        { id: 1, label: "Basic", link: "/auth-lockscreen-basic" },
                        { id: 2, label: "Cover", link: "/auth-lockscreen-cover" },
                    ]
                },
                {
                    id: "logout",
                    label: "Logout",
                    link: "/#",
                    isChildItem: true,
                    click: function (e) {
                        e.preventDefault();
                        setIsLogout(!isLogout);
                    },
                    parentId: "authentication",
                    stateVariables: isLogout,
                    childItems: [
                        { id: 1, label: "Basic", link: "/auth-logout-basic" },
                        { id: 2, label: "Cover", link: "/auth-logout-cover" },
                    ]
                },
                {
                    id: "successMessage",
                    label: "Success Message",
                    link: "/#",
                    isChildItem: true,
                    click: function (e) {
                        e.preventDefault();
                        setIsSuccessMessage(!isSuccessMessage);
                    },
                    parentId: "authentication",
                    stateVariables: isSuccessMessage,
                    childItems: [
                        { id: 1, label: "Basic", link: "/auth-success-msg-basic" },
                        { id: 2, label: "Cover", link: "/auth-success-msg-cover" },
                    ]
                },
                {
                    id: "twoStepVerification",
                    label: "Two Step Verification",
                    link: "/#",
                    isChildItem: true,
                    click: function (e) {
                        e.preventDefault();
                        setIsVerification(!isVerification);
                    },
                    parentId: "authentication",
                    stateVariables: isVerification,
                    childItems: [
                        { id: 1, label: "Basic", link: "/auth-twostep-basic" },
                        { id: 2, label: "Cover", link: "/auth-twostep-cover" },
                    ]
                },
                {
                    id: "errors",
                    label: "Errors",
                    link: "/#",
                    isChildItem: true,
                    click: function (e) {
                        e.preventDefault();
                        setIsError(!isError);
                    },
                    parentId: "authentication",
                    stateVariables: isError,
                    childItems: [
                        { id: 1, label: "404 Basic", link: "/auth-404-basic" },
                        { id: 2, label: "404 Cover", link: "/auth-404-cover" },
                        { id: 3, label: "404 Alt", link: "/auth-404-alt" },
                        { id: 4, label: "500", link: "/auth-500" },
                        { id: 5, label: "Offline Page", link: "/auth-offline" },
                    ]
                },
            ],
        },
        {
            id: "pages",
            label: "Pages",
            icon: "ri-pages-line",
            link: "/#",
            click: function (e) {
                e.preventDefault();
                setIsPages(!isPages);
                setIscurrentState('Pages');
                updateIconSidebar(e);
            },
            stateVariables: isPages,
            subItems: [
                {
                    id: "starter",
                    label: "Starter",
                    link: "/pages-starter",
                    parentId: "pages",
                },
                {
                    id: "profile",
                    label: "Profile",
                    link: "/#",
                    isChildItem: true,
                    click: function (e) {
                        e.preventDefault();
                        setIsProfile(!isProfile);
                    },
                    parentId: "pages",
                    stateVariables: isProfile,
                    childItems: [
                        { id: 1, label: "Simple Page", link: "/pages-profile", parentId: "pages" },
                        { id: 2, label: "Settings", link: "/pages-profile-settings", parentId: "pages" },
                    ]
                },
                { id: "team", label: "Team", link: "/pages-team", parentId: "pages" },
                { id: "timeline", label: "Timeline", link: "/pages-timeline", parentId: "pages" },
                { id: "faqs", label: "FAQs", link: "/pages-faqs", parentId: "pages" },
                { id: "pricing", label: "Pricing", link: "/pages-pricing", parentId: "pages" },
                { id: "gallery", label: "Gallery", link: "/pages-gallery", parentId: "pages" },
                { id: "maintenance", label: "Maintenance", link: "/pages-maintenance", parentId: "pages" },
                { id: "comingSoon", label: "Coming Soon", link: "/pages-coming-soon", parentId: "pages" },
                { id: "sitemap", label: "Sitemap", link: "/pages-sitemap", parentId: "pages" },
                { id: "searchResults", label: "Search Results", link: "/pages-search-results", parentId: "pages" },
                { id: "PrivecyPolicy", label: "Privacy Policy", link: "/pages-privecy-policy", parentId: "pages", },
                { id: "TermCondition", label: "Term & Conditions", link: "/pages-terms-condition", parentId: "pages", },
                {
                    id: "blogs",
                    label: "Blogs",
                    link: "/#",
                    isChildItem: true,
                    badgeColor: "success", badgeName: "New",
                    click: function (e) {
                      e.preventDefault();
                      setIsBlog(!isBlog);
                    },
                    parentId: "pages",
                    stateVariables: isBlog,
                    childItems: [
                      { id: 1, label: "List View", link: "/pages-blog-list", parentId: "pages" },
                      { id: 2, label: "Grid View", link: "/pages-blog-grid", parentId: "pages" },
                      { id: 3, label: "Overview", link: "/pages-blog-overview", parentId: "pages" },
                    ]
                  }
            ],
        },
        {
            id: "landing",
            label: "Landing",
            icon: "ri-rocket-line",
            link: "/#",
            stateVariables: isLanding,
            click: function (e) {
                e.preventDefault();
                setIsLanding(!isLanding);
                setIscurrentState('Landing');
                updateIconSidebar(e);
            },
            subItems: [
                { id: "onePage", label: "One Page", link: "/landing", parentId: "landing" },
                { id: "nftLanding", label: "NFT Landing", link: "/nft-landing", parentId: "landing" },
                { id: "jobLanding", label: "Job", link: "/job-landing", parentId: "landing", },
            ],
        },
        {
            label: "Components",
            isHeader: true,
        },
        {
            id: "baseUi",
            label: "Base UI",
            icon: "ri-pencil-ruler-2-line",
            link: "/#",
            click: function (e) {
                e.preventDefault();
                setIsBaseUi(!isBaseUi);
                setIscurrentState('BaseUi');
                updateIconSidebar(e);
            },
            stateVariables: isBaseUi,
            subItems: [
                { id: "alerts", label: "Alerts", link: "/ui-alerts", parentId: "baseUi" },
                { id: "badges", label: "Badges", link: "/ui-badges", parentId: "baseUi" },
                { id: "buttons", label: "Buttons", link: "/ui-buttons", parentId: "baseUi" },
                { id: "colors", label: "Colors", link: "/ui-colors", parentId: "baseUi" },
                { id: "cards", label: "Cards", link: "/ui-cards", parentId: "baseUi" },
                { id: "carousel", label: "Carousel", link: "/ui-carousel", parentId: "baseUi" },
                { id: "dropdowns", label: "Dropdowns", link: "/ui-dropdowns", parentId: "baseUi" },
                { id: "grid", label: "Grid", link: "/ui-grid", parentId: "baseUi" },
                { id: "images", label: "Images", link: "/ui-images", parentId: "baseUi" },
                { id: "tabs", label: "Tabs", link: "/ui-tabs", parentId: "baseUi" },
                { id: "accordions", label: "Accordion & Collapse", link: "/ui-accordions", parentId: "baseUi" },
                { id: "modals", label: "Modals", link: "/ui-modals", parentId: "baseUi" },
                { id: "offcanvas", label: "Offcanvas", link: "/ui-offcanvas", parentId: "baseUi" },
                { id: "placeholders", label: "Placeholders", link: "/ui-placeholders", parentId: "baseUi" },
                { id: "progress", label: "Progress", link: "/ui-progress", parentId: "baseUi" },
                { id: "notifications", label: "Notifications", link: "/ui-notifications", parentId: "baseUi" },
                { id: "media", label: "Media object", link: "/ui-media", parentId: "baseUi" },
                { id: "embedvideo", label: "Embed Video", link: "/ui-embed-video", parentId: "baseUi" },
                { id: "typography", label: "Typography", link: "/ui-typography", parentId: "baseUi" },
                { id: "lists", label: "Lists", link: "/ui-lists", parentId: "baseUi" },
                { id: "links", label: "Links", link: "/ui-links", parentId: "baseUi", badgeName: "New", badgeColor: "success" },
                { id: "general", label: "General", link: "/ui-general", parentId: "baseUi" },
                { id: "ribbons", label: "Ribbons", link: "/ui-ribbons", parentId: "baseUi" },
                { id: "utilities", label: "Utilities", link: "/ui-utilities", parentId: "baseUi" },
            ],
        },
        {
            id: "advanceUi",
            label: "Advance UI",
            icon: "ri-stack-line",
            link: "/#",
            click: function (e) {
                e.preventDefault();
                setIsAdvanceUi(!isAdvanceUi);
                setIscurrentState('AdvanceUi');
                updateIconSidebar(e);
            },
            stateVariables: isAdvanceUi,
            subItems: [
                { id: "nestablelist", label: "Nestable List", link: "/advance-ui-nestable", parentId: "advanceUi" },
                { id: "scrollbar", label: "Scrollbar", link: "/advance-ui-scrollbar", parentId: "advanceUi" },
                { id: "animation", label: "Animation", link: "/advance-ui-animation", parentId: "advanceUi" },
                { id: "swiperslider", label: "Swiper Slider", link: "/advance-ui-swiper", parentId: "advanceUi" },
                { id: "ratings", label: "Ratings", link: "/advance-ui-ratings", parentId: "advanceUi" },
                { id: "highlight", label: "Highlight", link: "/advance-ui-highlight", parentId: "advanceUi" },
            ],
        },
        {
            id: "widgets",
            label: "Widgets",
            icon: "ri-honour-line",
            link: "/widgets",
            click: function (e) {
                e.preventDefault();
                setIscurrentState('Widgets');
            }
        },
        {
            id: "forms",
            label: "Forms",
            icon: "ri-file-list-3-line",
            link: "/#",
            click: function (e) {
                e.preventDefault();
                setIsForms(!isForms);
                setIscurrentState('Forms');
                updateIconSidebar(e);
            },
            stateVariables: isForms,
            subItems: [
                { id: "basicelements", label: "Basic Elements", link: "/forms-elements", parentId: "forms" },
                { id: "formselect", label: "Form Select", link: "/forms-select", parentId: "forms" },
                { id: "checkboxsradios", label: "Checkboxs & Radios", link: "/forms-checkboxes-radios", parentId: "forms" },
                { id: "pickers", label: "Pickers", link: "/forms-pickers", parentId: "forms" },
                { id: "inputmasks", label: "Input Masks", link: "/forms-masks", parentId: "forms" },
                { id: "advanced", label: "Advanced", link: "/forms-advanced", parentId: "forms" },
                { id: "rangeslider", label: "Range Slider", link: "/forms-range-sliders", parentId: "forms" },
                { id: "validation", label: "Validation", link: "/forms-validation", parentId: "forms" },
                { id: "wizard", label: "Wizard", link: "/forms-wizard", parentId: "forms" },
                { id: "editors", label: "Editors", link: "/forms-editors", parentId: "forms" },
                { id: "fileuploads", label: "File Uploads", link: "/forms-file-uploads", parentId: "forms" },
                { id: "formlayouts", label: "Form Layouts", link: "/forms-layouts", parentId: "forms" },
                { id: "select2", label: "Select2", link: "/forms-select2", parentId: "forms" },
            ],
        },
        {
            id: "tables",
            label: "Tables",
            icon: "ri-layout-grid-line",
            link: "/#",
            click: function (e) {
                e.preventDefault();
                setIsTables(!isTables);
                setIscurrentState('Tables');
                updateIconSidebar(e);
            },
            stateVariables: isTables,
            subItems: [
                { id: "basictables", label: "Basic Tables", link: "/tables-basic", parentId: "tables" },
                { id: "listjs", label: "List Js", link: "/tables-listjs", parentId: "tables" },
                { id: "reactdatatables", label: "React Datatables", link: "/tables-react", parentId: "tables" },
            ],
        },
        {
            id: "charts",
            label: "Charts",
            icon: "ri-pie-chart-line",
            link: "/#",
            click: function (e) {
                e.preventDefault();
                setIsCharts(!isCharts);
                setIscurrentState('Charts');
                updateIconSidebar(e);
            },
            stateVariables: isCharts,
            subItems: [
                {
                    id: "apexcharts",
                    label: "Apexcharts",
                    link: "/#",
                    isChildItem: true,
                    click: function (e) {
                        e.preventDefault();
                        setIsApex(!isApex);
                    },
                    stateVariables: isApex,
                    childItems: [
                        { id: 1, label: "Line", link: "/charts-apex-line" },
                        { id: 2, label: "Area", link: "/charts-apex-area" },
                        { id: 3, label: "Column", link: "/charts-apex-column" },
                        { id: 4, label: "Bar", link: "/charts-apex-bar" },
                        { id: 5, label: "Mixed", link: "/charts-apex-mixed" },
                        { id: 6, label: "Timeline", link: "/charts-apex-timeline" },
                        { id: 7, label: "Range Area", link: "/charts-apex-range-area", badgeName: "New", badgeColor: "success" },
                        { id: 8, label: "Funnel", link: "/charts-apex-funnel", badgeName: "New", badgeColor: "success" },
                        { id: 9, label: "Candlstick", link: "/charts-apex-candlestick" },
                        { id: 10, label: "Boxplot", link: "/charts-apex-boxplot" },
                        { id: 11, label: "Bubble", link: "/charts-apex-bubble" },
                        { id: 12, label: "Scatter", link: "/charts-apex-scatter" },
                        { id: 13, label: "Heatmap", link: "/charts-apex-heatmap" },
                        { id: 14, label: "Treemap", link: "/charts-apex-treemap" },
                        { id: 15, label: "Pie", link: "/charts-apex-pie" },
                        { id: 16, label: "Radialbar", link: "/charts-apex-radialbar" },
                        { id: 17, label: "Radar", link: "/charts-apex-radar" },
                        { id: 18, label: "Polar Area", link: "/charts-apex-polar" },
                        { id: 19, label: "Slope", link: "/charts-apex-slope", parentId: "charts", badgeColor: "success", badgeName: "New" },
                    ]
                },
                { id: "chartjs", label: "Chartjs", link: "/charts-chartjs", parentId: "charts" },
                { id: "echarts", label: "Echarts", link: "/charts-echarts", parentId: "charts" },
            ],
        },
        {
            id: "icons",
            label: "Icons",
            icon: "ri-compasses-2-line",
            link: "/#",
            click: function (e) {
                e.preventDefault();
                setIsIcons(!isIcons);
                setIscurrentState('Icons');
                updateIconSidebar(e);
            },
            stateVariables: isIcons,
            subItems: [
                { id: "remix", label: "Remix", link: "/icons-remix", parentId: "icons" },
                { id: "boxicons", label: "Boxicons", link: "/icons-boxicons", parentId: "icons" },
                { id: "materialdesign", label: "Material Design", link: "/icons-materialdesign", parentId: "icons" },
                { id: "lineawesome", label: "Line Awesome", link: "/icons-lineawesome", parentId: "icons" },
                { id: "feather", label: "Feather", link: "/icons-feather", parentId: "icons" },
                { id: "crypto", label: "Crypto SVG", link: "/icons-crypto", parentId: "icons" },
            ],
        },
        {
            id: "maps",
            label: "Maps",
            icon: "ri-map-pin-line",
            link: "/#",
            click: function (e) {
                e.preventDefault();
                setIsMaps(!isMaps);
                setIscurrentState('Maps');
                updateIconSidebar(e);
            },
            stateVariables: isMaps,
            subItems: [
                { id: "google", label: "Google", link: "/maps-google", parentId: "maps" },
            ],
        },
        {
            id: "multilevel",
            label: "Multi Level",
            icon: "ri-share-line",
            link: "/#",
            click: function (e) {
                e.preventDefault();
                setIsMultiLevel(!isMultiLevel);
                setIscurrentState('MuliLevel');
                updateIconSidebar(e);
            },
            stateVariables: isMultiLevel,
            subItems: [
                { id: "level1.1", label: "Level 1.1", link: "/#", parentId: "multilevel" },
                {
                    id: "level1.2",
                    label: "Level 1.2",
                    link: "/#",
                    isChildItem: true,
                    click: function (e) {
                        e.preventDefault();
                        setIsLevel1(!isLevel1);
                    },
                    stateVariables: isLevel1,
                    childItems: [
                        { id: 1, label: "Level 2.1", link: "/#" },
                        {
                            id: "level2.2",
                            label: "Level 2.2",
                            link: "/#",
                            isChildItem: true,
                            click: function (e) {
                                e.preventDefault();
                                setIsLevel2(!isLevel2);
                            },
                            stateVariables: isLevel2,
                            childItems: [
                                { id: 1, label: "Level 3.1", link: "/#" },
                                { id: 2, label: "Level 3.2", link: "/#" },
                            ]
                        },
                    ]
                },
            ],
        },
        {
            id: "dashboardV2",
            label: "Dashboard",
            icon: "ri-dashboard-2-line",
            link: "/#",
            click: function (e) {
                e.preventDefault();
                setIsDashboardV2(!isDashboardV2);
                setIscurrentState('DashboardV2');
                updateIconSidebar(e);
            },
            stateVariables: isDashboardV2,
            subItems: [
                {
                    id: "dashboardV2-accounting",
                    label: "Accounting",
                    icon: "ri-file-list-2-line",
                    link: "/#",
                    isChildItem: true,
                    click: function (e) {
                        e.preventDefault();
                        setIsDashboardV2Accounting(!isDashboardV2Accounting);
                        setIscurrentState('DashboardV2Accounting');
                        updateIconSidebar(e);
                    },
                    stateVariables: isDashboardV2Accounting,
                    childItems: [
                        {
                            id: "dashboardV2-accounting-overview",
                            label: "Overview",
                            link: "/dashboardv2/accounting/overview",
                        },
                        {
                            id: "dashboardV2-accounting-reports",
                            label: "Reports",
                            link: "/#",
                            isChildItem: true,
                            click: function (e) {
                                e.preventDefault();
                                setIsDashboardV2AccountingReports(!isDashboardV2AccountingReports);
                            },
                            stateVariables: isDashboardV2AccountingReports,
                            childItems: [
                                { id: "dashboardV2-account-statement", label: "Account Statement", link: "/dashboardv2/accounting/reports/account-statement" },
                                { id: "dashboardV2-invoice-summary", label: "Invoice Summary", link: "/dashboardv2/accounting/reports/invoice-summary" },
                                { id: "dashboardV2-sales-report", label: "Sales Report", link: "/dashboardv2/accounting/reports/sales-report" },
                                { id: "dashboardV2-receivables", label: "Receivables", link: "/dashboardv2/accounting/reports/receivables" },
                                { id: "dashboardV2-payables", label: "Payables", link: "/dashboardv2/accounting/reports/payables" },
                                { id: "dashboardV2-bill-summary", label: "Bill Summary", link: "/dashboardv2/accounting/reports/bill-summary" },
                                { id: "dashboardV2-product-stock", label: "Product Stock", link: "/dashboardv2/accounting/reports/product-stock" },
                                { id: "dashboardV2-cash-flow", label: "Cash Flow", link: "/dashboardv2/accounting/reports/cash-flow" },
                                { id: "dashboardV2-transaction", label: "Transaction", link: "/dashboardv2/accounting/reports/transaction" },
                                { id: "dashboardV2-income-summary", label: "Income Summary", link: "/dashboardv2/accounting/reports/income-summary" },
                                { id: "dashboardV2-expense-summary", label: "Expense Summary", link: "/dashboardv2/accounting/reports/expense-summary" },
                                { id: "dashboardV2-income-vs-expense", label: "Income VS Expense", link: "/dashboardv2/accounting/reports/income-vs-expense" },
                                { id: "dashboardV2-tax-summary", label: "Tax Summary", link: "/dashboardv2/accounting/reports/tax-summary" },
                            ]
                        }
                    ]
                },
                {
                    id: "dashboardV2-hrm",
                    label: "HRM",
                    icon: "ri-user-line",
                    link: "/#",
                    isChildItem: true,
                    click: function (e) {
                        e.preventDefault();
                        setIsDashboardV2HRM(!isDashboardV2HRM);
                        setIscurrentState('DashboardV2HRM');
                        updateIconSidebar(e);
                    },
                    stateVariables: isDashboardV2HRM,
                    childItems: [
                        { id: "dashboardV2-hrm-overview", label: "Overview", link: "/dashboardv2/hrm/overview" },
                        { id: "dashboardV2-hrm-reports", label: "Reports", link: "/dashboardv2/hrm/reports" },
                        { id: "dashboardV2-hrm-payroll", label: "Payroll", link: "/dashboardv2/hrm/payroll" },
                        { id: "dashboardV2-hrm-leave", label: "Leave", link: "/dashboardv2/hrm/leave" },
                        { id: "dashboardV2-hrm-monthly-attendance", label: "Monthly Attendance", link: "/dashboardv2/hrm/monthly-attendance" },
                    ]
                },
                {
                    id: "dashboardV2-crm",
                    label: "CRM",
                    icon: "ri-customer-service-2-line",
                    link: "/#",
                    isChildItem: true,
                    click: function (e) {
                        e.preventDefault();
                        setIsDashboardV2CRM(!isDashboardV2CRM);
                        setIscurrentState('DashboardV2CRM');
                        updateIconSidebar(e);
                    },
                    stateVariables: isDashboardV2CRM,
                    childItems: [
                        { id: "dashboardV2-crm-overview", label: "Overview", link: "/dashboardv2/crm/overview" },
                        { id: "dashboardV2-crm-reports", label: "Reports", link: "/dashboardv2/crm/reports" },
                        { id: "dashboardV2-crm-lead", label: "Lead", link: "/dashboardv2/crm/lead" },
                        { id: "dashboardV2-crm-deal", label: "Deal", link: "/dashboardv2/crm/deal" },
                    ]
                },
                {
                    id: "dashboardV2-project",
                    label: "Project",
                    icon: "ri-folder-line",
                    link: "/dashboardv2/project",
                },
                {
                    id: "dashboardV2-pos",
                    label: "POS",
                    icon: "ri-store-line",
                    link: "/#",
                    isChildItem: true,
                    click: function (e) {
                        e.preventDefault();
                        setIsDashboardV2POS(!isDashboardV2POS);
                        setIscurrentState('DashboardV2POS');
                        updateIconSidebar(e);
                    },
                    stateVariables: isDashboardV2POS,
                    childItems: [
                        { id: "dashboardV2-pos-overview", label: "Overview", link: "/dashboardv2/pos/overview" },
                        {
                            id: "dashboardV2-pos-reports",
                            label: "Reports",
                            link: "/#",
                            isChildItem: true,
                            click: function (e) {
                                e.preventDefault();
                                setIsDashboardV2POSReports(!isDashboardV2POSReports);
                            },
                            stateVariables: isDashboardV2POSReports,
                            childItems: [
                                { id: "dashboardV2-warehouse-report", label: "Warehouse Report", link: "/dashboardv2/pos/reports/warehouse-report" },
                                { id: "dashboardV2-purchase-daily-monthly-report", label: "Purchase Daily/Monthly Report", link: "/dashboardv2/pos/reports/purchase-daily-monthly-report" },
                                { id: "dashboardV2-pos-daily-monthly-report", label: "POS Daily/Monthly Report", link: "/dashboardv2/pos/reports/pos-daily-monthly-report" },
                                { id: "dashboardV2-pos-vs-purchase-report", label: "Pos VS Purchase Report", link: "/dashboardv2/pos/reports/pos-vs-purchase-report" },
                            ]
                        }
                    ]
                },
            ]
        },
        {
            id: "hrmSystem",
            label: "HRM System",
            icon: "ri-user-settings-line",
            link: "/#",
            click: function (e) {
                e.preventDefault();
                setIsHRMSystem(!isHRMSystem);
                setIscurrentState('HRMSystem');
                updateIconSidebar(e);
            },
            stateVariables: isHRMSystem,
            subItems: [
                {
                    id: "hrmSystem-employee-setup",
                    label: "Employee Setup",
                    link: "/hrm-system/employee-setup",
                },
                {
                    id: "hrmSystem-payroll-setup",
                    label: "Payroll Setup",
                    link: "/#",
                    isChildItem: true,
                    click: function (e) {
                        e.preventDefault();
                        setIsHRMSystemPayrollSetup(!isHRMSystemPayrollSetup);
                    },
                    stateVariables: isHRMSystemPayrollSetup,
                    childItems: [
                        { id: "hrmSystem-set-salary", label: "Set Salary", link: "/hrm-system/payroll-setup/set-salary" },
                        { id: "hrmSystem-payslip", label: "Payslip", link: "/hrm-system/payroll-setup/payslip" },
                    ]
                },
                {
                    id: "hrmSystem-leave-management-setup",
                    label: "Leave Management Setup",
                    link: "/#",
                    isChildItem: true,
                    click: function (e) {
                        e.preventDefault();
                        setIsHRMSystemLeaveManagementSetup(!isHRMSystemLeaveManagementSetup);
                    },
                    stateVariables: isHRMSystemLeaveManagementSetup,
                    childItems: [
                        { id: "hrmSystem-manage-leave", label: "Manage Leave", link: "/hrm-system/leave-management-setup/manage-leave" },
                        {
                            id: "hrmSystem-attendance",
                            label: "Attendance",
                            link: "/#",
                            isChildItem: true,
                            click: function (e) {
                                e.preventDefault();
                                setIsHRMSystemAttendance(!isHRMSystemAttendance);
                            },
                            stateVariables: isHRMSystemAttendance,
                            childItems: [
                                { id: "hrmSystem-mark-attendance", label: "Mark Attendance", link: "/hrm-system/leave-management-setup/attendance/mark-attendance" },
                                { id: "hrmSystem-bulk-attendance", label: "Bulk Attendance", link: "/hrm-system/leave-management-setup/attendance/bulk-attendance" },
                            ]
                        },
                    ]
                },
                {
                    id: "hrmSystem-performance-setup",
                    label: "Performance Setup",
                    link: "/#",
                    isChildItem: true,
                    click: function (e) {
                        e.preventDefault();
                        setIsHRMSystemPerformanceSetup(!isHRMSystemPerformanceSetup);
                    },
                    stateVariables: isHRMSystemPerformanceSetup,
                    childItems: [
                        { id: "hrmSystem-indicator", label: "Indicator", link: "/hrm-system/performance-setup/indicator" },
                        { id: "hrmSystem-appraisal", label: "Appraisal", link: "/hrm-system/performance-setup/appraisal" },
                        { id: "hrmSystem-goal-tracking", label: "Goal Tracking", link: "/hrm-system/performance-setup/goal-tracking" },
                    ]
                },
                {
                    id: "hrmSystem-training-setup",
                    label: "Training Setup",
                    link: "/#",
                    isChildItem: true,
                    click: function (e) {
                        e.preventDefault();
                        setIsHRMSystemTrainingSetup(!isHRMSystemTrainingSetup);
                    },
                    stateVariables: isHRMSystemTrainingSetup,
                    childItems: [
                        { id: "hrmSystem-training-list", label: "Training List", link: "/hrm-system/training-setup/training-list" },
                        { id: "hrmSystem-trainer", label: "Trainer", link: "/hrm-system/training-setup/trainer" },
                    ]
                },
                {
                    id: "hrmSystem-recruitment-setup",
                    label: "Recruitment Setup",
                    link: "/#",
                    isChildItem: true,
                    click: function (e) {
                        e.preventDefault();
                        setIsHRMSystemRecruitmentSetup(!isHRMSystemRecruitmentSetup);
                    },
                    stateVariables: isHRMSystemRecruitmentSetup,
                    childItems: [
                        { id: "hrmSystem-jobs", label: "Jobs", link: "/hrm-system/recruitment-setup/jobs" },
                        { id: "hrmSystem-job-create", label: "Job Create", link: "/hrm-system/recruitment-setup/job-create" },
                        { id: "hrmSystem-job-application", label: "Job Application", link: "/hrm-system/recruitment-setup/job-application" },
                        {
                            id: "hrmSystem-job-candidate",
                            label: "Job Candidate",
                            link: "/#",
                            isChildItem: true,
                            click: function (e) {
                                e.preventDefault();
                                setIsHRMSystemJobCandidate(!isHRMSystemJobCandidate);
                            },
                            stateVariables: isHRMSystemJobCandidate,
                            childItems: [
                                { id: "hrmSystem-job-onboarding", label: "Job On-boarding", link: "/hrm-system/recruitment-setup/job-candidate/job-onboarding" },
                                { id: "hrmSystem-custom-question", label: "Custom Question", link: "/hrm-system/recruitment-setup/job-candidate/custom-question" },
                                { id: "hrmSystem-interview-schedule", label: "Interview Schedule", link: "/hrm-system/recruitment-setup/job-candidate/interview-schedule" },
                                { id: "hrmSystem-career", label: "Career", link: "/hrm-system/recruitment-setup/job-candidate/career" },
                            ]
                        },
                    ]
                },
                {
                    id: "hrmSystem-hr-admin-setup",
                    label: "HR Admin Setup",
                    link: "/#",
                    isChildItem: true,
                    click: function (e) {
                        e.preventDefault();
                        setIsHRMSystemHRAdminSetup(!isHRMSystemHRAdminSetup);
                    },
                    stateVariables: isHRMSystemHRAdminSetup,
                    childItems: [
                        { id: "hrmSystem-award", label: "Award", link: "/hrm-system/hr-admin-setup/award" },
                        { id: "hrmSystem-transfer", label: "Transfer", link: "/hrm-system/hr-admin-setup/transfer" },
                        { id: "hrmSystem-resignation", label: "Resignation", link: "/hrm-system/hr-admin-setup/resignation" },
                        { id: "hrmSystem-trip", label: "Trip", link: "/hrm-system/hr-admin-setup/trip" },
                        { id: "hrmSystem-promotion", label: "Promotion", link: "/hrm-system/hr-admin-setup/promotion" },
                        { id: "hrmSystem-complaints", label: "Complaints", link: "/hrm-system/hr-admin-setup/complaints" },
                        { id: "hrmSystem-warning", label: "Warning", link: "/hrm-system/hr-admin-setup/warning" },
                        { id: "hrmSystem-termination", label: "Termination", link: "/hrm-system/hr-admin-setup/termination" },
                        { id: "hrmSystem-announcement", label: "Announcement", link: "/hrm-system/hr-admin-setup/announcement" },
                        { id: "hrmSystem-holidays", label: "Holidays", link: "/hrm-system/hr-admin-setup/holidays" },
                    ]
                },
                { id: "hrmSystem-event-setup", label: "Event Setup", link: "/hrm-system/event-setup" },
                { id: "hrmSystem-meeting", label: "Meeting", link: "/hrm-system/meeting" },
                { id: "hrmSystem-employees-asset-setup", label: "Employees Asset Setup", link: "/hrm-system/employees-asset-setup" },
                { id: "hrmSystem-document-setup", label: "Document Setup", link: "/hrm-system/document-setup" },
                { id: "hrmSystem-company-policy", label: "Company Policy", link: "/hrm-system/company-policy" },
                { id: "hrmSystem-hrm-system-setup", label: "HRM System Setup", link: "/hrm-system/hrm-system-setup" },
            ]
        },
        {
            id: "medical-management",
            label: "Medical Management",
            icon: "ri-hospital-line",
            link: "/#",
            click: function (e) {
                e.preventDefault();
                setIsMedicalManagement(!isMedicalManagement);
                setIscurrentState('MedicalManagement');
                updateIconSidebar(e);
            },
            stateVariables: isMedicalManagement,
            subItems: [
                // { id: "specializations", label: "Specializations", link: "/medical/specializations" },
                { id: "specializations-datatable", label: "Specializations (DataTables)", link: "/medical/specializations-datatable" },
                // { id: "medicine-categories", label: "Medicine Categories", link: "/medical/medicine-categories" },
                { id: "medicine-categories-datatable", label: "Medicine Categories (DataTables)", link: "/medical/medicine-categories-datatable" },
                // { id: "doses", label: "Doses", link: "/medical/doses" },
                { id: "doses-datatable", label: "Doses (DataTables)", link: "/medical/doses-datatable" },
                // { id: "dose-intervals", label: "Dose Intervals", link: "/medical/dose-intervals" },
                { id: "dose-intervals-datatable", label: "Dose Intervals (DataTables)", link: "/medical/dose-intervals-datatable" },
                // { id: "dose-durations", label: "Dose Durations" },
                // { id: "patient", label: "Patient" },
                { id: "opd-patients-datatable", label: "OPD Patients (DataTables)", link: "/opd/patients-datatable" },
                // { id: "opd-out-patient", label: "OPD - Out Patient" },
                { id: "charge-types", label: "Charge Types" },
                { id: "modules", label: "Modules" },
                { id: "taxes", label: "Taxes" },
                { id: "unit-types", label: "Unit Types" },
                { id: "charge-categories", label: "Charge Categories" },
                { id: "charges", label: "Charges" },
                { id: "nurse", label: "Nurse" },
            ],
        },
    ];
    return <React.Fragment>{menuItems}</React.Fragment>;
};
export default Navdata;
