import { useTranslation } from "@/contexts/LocalizationContext";
import { trpc } from "@/lib/trpc";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Textarea } from "@/components/ui/textarea";
import { useLocation } from "wouter";
import { useState, useRef } from "react";
import { toast } from "sonner";

export default function CreateProduct() {
  const { t } = useTranslation();
  const [, navigate] = useLocation();
  const fileInputRef = useRef<HTMLInputElement>(null);
  const [isLoading, setIsLoading] = useState(false);
  const [previewUrl, setPreviewUrl] = useState<string | null>(null);

  const createMutation = trpc.products.create.useMutation({
    onSuccess: () => {
      toast.success("Product created successfully!");
      navigate("/products");
    },
    onError: (error) => {
      toast.error(error.message || "Failed to create product");
    },
  });

  const handleFileChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const file = e.target.files?.[0];
    if (!file) return;

    // Validate file type
    if (!["image/jpeg", "image/png"].includes(file.type)) {
      toast.error("Only JPG and PNG files are allowed");
      return;
    }

    // Validate file size (2MB max)
    if (file.size > 2 * 1024 * 1024) {
      toast.error("File size must be less than 2MB");
      return;
    }

    // Create preview
    const reader = new FileReader();
    reader.onloadend = () => {
      setPreviewUrl(reader.result as string);
    };
    reader.readAsDataURL(file);
  };

  const handleSubmit = async (e: React.FormEvent<HTMLFormElement>) => {
    e.preventDefault();
    setIsLoading(true);

    const formData = new FormData(e.currentTarget);
    const name = formData.get("name") as string;
    const description = formData.get("description") as string;
    const file = fileInputRef.current?.files?.[0];

    // Validation
    if (!name || name.length < 3) {
      toast.error("Product name must be at least 3 characters");
      setIsLoading(false);
      return;
    }

    if (!description || description.length < 10) {
      toast.error("Product description must be at least 10 characters");
      setIsLoading(false);
      return;
    }

    if (!file) {
      toast.error("Please select an image");
      setIsLoading(false);
      return;
    }

    // Upload file and create product
    try {
      const reader = new FileReader();
      reader.onload = async () => {
        const imageData = reader.result as string;
        await createMutation.mutateAsync({
          name,
          description,
          image: imageData,
        });
      };
      reader.readAsDataURL(file);
    } catch (error) {
      console.error("Error creating product:", error);
    } finally {
      setIsLoading(false);
    }
  };

  return (
    <div className="min-h-screen bg-background py-8">
      <div className="container mx-auto px-4 max-w-md">
        <h1 className="text-3xl font-bold text-foreground mb-8">
          {t("nav.addProduct")}
        </h1>

        <form onSubmit={handleSubmit} className="space-y-6">
          <div>
            <label className="block text-sm font-medium text-foreground mb-2">
              {t("form.name")}
            </label>
            <Input
              type="text"
              name="name"
              placeholder={t("form.name")}
              required
              minLength={3}
            />
            <p className="text-xs text-muted-foreground mt-1">
              {t("form.nameRequired")}
            </p>
          </div>

          <div>
            <label className="block text-sm font-medium text-foreground mb-2">
              {t("form.description")}
            </label>
            <Textarea
              name="description"
              placeholder={t("form.description")}
              required
              minLength={10}
              rows={4}
            />
            <p className="text-xs text-muted-foreground mt-1">
              {t("form.descriptionRequired")}
            </p>
          </div>

          <div>
            <label className="block text-sm font-medium text-foreground mb-2">
              {t("form.image")}
            </label>
            <Input
              ref={fileInputRef}
              type="file"
              name="image"
              accept="image/jpeg,image/png"
              onChange={handleFileChange}
              required
            />
            <p className="text-xs text-muted-foreground mt-1">
              {t("form.imageRequired")}
            </p>

            {previewUrl && (
              <div className="mt-4">
                <img
                  src={previewUrl}
                  alt="Preview"
                  className="w-full h-48 object-cover rounded-lg"
                />
              </div>
            )}
          </div>

          <div className="flex gap-4">
            <Button
              type="submit"
              disabled={isLoading || createMutation.isPending}
              className="flex-1"
            >
              {isLoading || createMutation.isPending
                ? "Loading..."
                : t("form.submit")}
            </Button>
            <Button
              type="button"
              variant="outline"
              className="flex-1"
              onClick={() => navigate("/products")}
            >
              {t("form.cancel")}
            </Button>
          </div>
        </form>
      </div>
    </div>
  );
}
