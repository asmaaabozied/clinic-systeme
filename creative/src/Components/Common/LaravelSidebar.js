import React from "react";
import { Link } from "react-router-dom";

// Example static menu structure based on menu.blade.php
const menu = [
  {
    label: "Dashboard",
    icon: "ti ti-home",
    children: [
      {
        label: "Accounting",
        children: [
          { label: "Overview", to: "/dashboard" },
          {
            label: "Reports",
            children: [
              { label: "Account Statement", to: "/report/account-statement" },
              { label: "Invoice Summary", to: "/report/invoice-summary" },
              { label: "Sales Report", to: "/report/sales" },
              { label: "Receivables", to: "/report/receivables" },
              { label: "Payables", to: "/report/payables" },
              { label: "Bill Summary", to: "/report/bill-summary" },
              { label: "Product Stock", to: "/report/product-stock" },
              { label: "Cash Flow", to: "/report/cash-flow" },
              { label: "Transaction", to: "/transaction" },
              { label: "Income Summary", to: "/report/income-summary" },
              { label: "Expense Summary", to: "/report/expense-summary" },
              { label: "Income VS Expense", to: "/report/income-vs-expense" },
              { label: "Tax Summary", to: "/report/tax-summary" },
            ],
          },
        ],
      },
    ],
  },
  // Add more top-level menu items here as needed
];

const renderMenu = (items) => (
  <ul className="laravel-sidebar-menu">
    {items.map((item, idx) => (
      <li key={idx} className="laravel-sidebar-item">
        {item.to ? (
          <Link to={item.to}>{item.label}</Link>
        ) : (
          <span className="laravel-sidebar-label">
            {item.icon && <i className={item.icon}></i>} {item.label}
          </span>
        )}
        {item.children && renderMenu(item.children)}
      </li>
    ))}
  </ul>
);

const LaravelSidebar = () => {
  return (
    <nav className="laravel-sidebar">
      {renderMenu(menu)}
    </nav>
  );
};

export default LaravelSidebar; 