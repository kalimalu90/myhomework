import { Toaster } from "@/components/ui/sonner";
import { TooltipProvider } from "@/components/ui/tooltip";
import NotFound from "@/pages/NotFound";
import { Route, Switch } from "wouter";
import ErrorBoundary from "./components/ErrorBoundary";
import { ThemeProvider } from "./contexts/ThemeContext";
import { LocalizationProvider } from "./contexts/LocalizationContext";
import Navbar from "./components/Navbar";
import Home from "./pages/Home";
import ProductsList from "./pages/ProductsList";
import ProductDetail from "./pages/ProductDetail";
import CreateProduct from "./pages/CreateProduct";

function Router() {
  return (
    <Switch>
      <Route path={"/"} component={Home} />
      <Route path={"/products"} component={ProductsList} />
      <Route path={"/products/:id"} component={ProductDetail} />
      <Route path={"/create"} component={CreateProduct} />
      <Route path={"/404"} component={NotFound} />
      {/* Final fallback route */}
      <Route component={NotFound} />
    </Switch>
  );
}

function App() {
  return (
    <ErrorBoundary>
      <ThemeProvider defaultTheme="light">
        <LocalizationProvider>
          <TooltipProvider>
            <Toaster />
            <Navbar />
            <Router />
          </TooltipProvider>
        </LocalizationProvider>
      </ThemeProvider>
    </ErrorBoundary>
  );
}

export default App;
